Vue.component('autocomplete', {
    template: `
    <div class="autocomplete nav navbar-nav">
    <div class="autocomplete__box" :class="{'autocomplete__searching' : showResults}">

      <img v-if="!isLoading" class="autocomplete__icon" src="./assets/img/vue/search.svg">
      <img v-else class="autocomplete__icon animate-spin" src="./assets/img/vue/loading.svg">

      <div class="autocomplete__inputs">
        <input
          v-model="display"
          :placeholder="placeholder"
          :disabled="disable_input"
          :maxlength="maxlength"
          :class="input_class"
          @click="search"
          @input="search"
          @keydown.enter="enter"
          @keydown.tab="close"
          @keydown.up="up"
          @keydown.down="down"
          @keydown.esc="close"
          @focus="focus"
          @blur="blur"
          type="text"
          autocomplete="off">
        <input :name="name" type="hidden" :value="value">
      </div>

      <!-- clear_button_icon -->
      <span v-show="!disable_input && !isEmpty && !isLoading && !hasError" class="autocomplete__icon autocomplete--clear" @click="clear">
        <span v-if="clear_button_icon" :class="clear_button_icon"></span>
        <img v-else src="./assets/img/vue/close.svg">
      </span>
    </div>

    <ul v-show="showResults" class="autocomplete__results" :style="listStyle">
      <slot name="results">
        <!-- error -->
        <li v-if="hasError" class="autocomplete__results__item autocomplete__results__item--error">{{ error }}</li>

        <!-- results -->
        <template v-if="!hasError">
          <slot name="firstResult"></slot>
          <li
              v-for="(result, key) in results"
              :key="key"
              @click.prevent="select(result)"
              class="autocomplete__results__item"
              :class="{'autocomplete__selected' : isSelected(key) }"
              v-html="formatDisplay(result)">
          </li>
          <slot name="lastResult"></slot>
        </template>

        <!-- no results -->
        <li v-if="noResultMessage" class="autocomplete__results__item autocomplete__no-results">
          <slot name="noResults">No Results.</slot>
        </li>
      </slot>
    </ul>
  </div>
    `,
    props: {
        /**
         * Data source for the results
         *   `String` is a url, typed input will be appended
         *   `Function` received typed input, and must return a string; to be used as a url
         *   `Array` and `Object` (see `results-property`) are used directly
         */
        source: {
          type: [String, Function, Array, Object],
          required: true
        },
        /**
         * http method
         */
        method: {
          type: String,
          default: 'get'
        },
        /**
         * Input placeholder
         */
        placeholder: {
          default: 'Search'
        },
        /**
         * Preset starting value
         */
        initial_value: {
          type: [String, Number]
        },
        /**
         * Preset starting display value
         */
        initial_display: {
          type: String
        },
        /**
         * CSS class for the surrounding input div
         */
        input_class: {
          type: [String, Object]
        },
        /**
         * To disable the input
         */
        disable_input: {
          type: Boolean
        },
        /**
         * name property of the input holding the selected value
         */
        name: {
          type: String
        },
        /**
         * api - property of results array
         */
        results_property: {
          type: String
        },
        /**
         * Results property used as the value
         */
        results_value: {
          type: String,
          default: 'id'
        },
        /**
         * Results property used as the display
         */
        results_display: {
          type: [String, Function],
          default: 'name'
        },
        /**
         * Callback to format the server data
         */
        results_formatter: {
          type: Function
        },
        /**
         * Whether to show the no results message
         */
        show_no_results: {
          type: Boolean,
          default: true
        },
        /**
         * Additional request headers
         */
        request_headers: {
          type: Object
        },
        /**
         * Credentials: same-origin, include, *omit
         */
        credentials: {
          type: String
        },
        /**
         * Optional clear button icon class
         */
        clear_button_icon: {
          type: String
        },
        /**
         * Optional max input length
         */
        maxlength: {
          type: Number
        }
      },
      data: function() {
          return {
          value: null,
          display: null,
          results: null,
          selectedIndex: null,
          loading: false,
          isFocussed: false,
          error: null,
          selectedId: null,
          selectedDisplay: null,
          eventListener: false
        }
      },
      computed: {
        showResults () {
          return Array.isArray(this.results) || this.hasError
        },
        noResults () {
          return Array.isArray(this.results) && this.results.length === 0
        },
        noResultMessage () {
          return this.noResults &&
            !this.isLoading &&
            this.isFocussed &&
            !this.hasError &&
            this.show_no_results
        },
        isEmpty () {
          return !this.display
        },
        isLoading () {
          return this.loading === true
        },
        hasError () {
          return this.error !== null
        },
        listStyle () {
          if (this.isLoading) {
            return {
              color: '#ccc'
            }
          }
        }
      },
      methods: {
        /**
         * Search wrapper method
         */
        search () {
          this.selectedIndex = null
          switch (true) {
            case typeof this.source === 'string':
              // No resource search with no input
              if (!this.display || this.display.length < 1) {
                return
              }
              return this.resourceSearch(this.source + this.display)
            case typeof this.source === 'function':
              // No resource search with no input
              if (!this.display || this.display.length < 1) {
                return
              }
              return this.resourceSearch(this.source(this.display))
            case Array.isArray(this.source):
              return this.arrayLikeSearch()
            default:
              throw new TypeError()
          }
        },
        /**
         * Debounce the typed search query before making http requests
         * @param {String} url
         */
        resourceSearch: debounce(function (url) {
          if (!this.display) {
            this.results = []
            return
          }
          this.loading = true
          this.setEventListener()
          this.request(url)
        }, 200),
        /**
         * Make an http request for results
         * @param {String} url
         */
        request (url) {
          let promise = fetch(url, {
            method: this.method,
            credentials: this.getCredentials(),
            headers: this.getHeaders()
          })
          return promise
            .then(response => {
              if (response.ok) {
                this.error = null
                return response.json()
              }
              throw new Error('Network response was not ok.')
            })
            .then(response => {
              this.results = this.setResults(response)
              this.emitRequestResultEvent()
              this.loading = false
            })
            .catch(error => {
              this.error = error.message
              this.loading = false
            })
        },
        /**
         * Set some default headers and apply user supplied headers
         */
        getHeaders () {
          const headers = {
            'Accept': 'application/json, text/plain, */*'
          }
          if (this.request_headers) {
            for (var prop in this.request_headers) {
              headers[prop] = this.request_headers[prop]
            }
          }
          return new Headers(headers)
        },
        /**
         * Set default credentials and apply user supplied value
         */
        getCredentials () {
          let credentials = 'same-origin'
          if (this.credentials) {
            credentials = this.credentials
          }
          return credentials
        },
        /**
         * Set results property from api response
         * @param {Object|Array} response
         * @return {Array}
         */
        setResults (response) {
          if (this.results_formatter) {
            return this.results_formatter(response)
          }
          if (this.results_property && response[this.results_property]) {
            return response[this.results_property]
          }
          if (Array.isArray(response)) {
            return response
          }
          return []
        },
        /**
         * Emit an event based on the request results
         */
        emitRequestResultEvent () {
          if (this.results.length === 0) {
            this.$emit('noResults', {query: this.display})
          } else {
            this.$emit('results', {results: this.results})
          }
        },
        /**
         * Search in results passed via an array
         */
        arrayLikeSearch () {
          this.setEventListener()
          if (!this.display) {
            this.results = this.source
            this.$emit('results', {results: this.results})
            this.loading = false
            return true
          }
          this.results = this.source.filter((item) => {
            return this.formatDisplay(item).toLowerCase().includes(this.display.toLowerCase())
          })
          this.$emit('results', {results: this.results})
          this.loading = false
        },
        /**
         * Select a result
         * @param {Object}
         */
        select (obj) {
          if (!obj) {
            return
          }
          this.value = (this.results_value && obj[this.results_value]) ? obj[this.results_value] : obj.id
          this.display = this.formatDisplay(obj)
          this.selectedDisplay = this.display
          this.$emit('selected', {
            value: this.value,
            display: this.display,
            selectedObject: obj
          })
          this.$emit('input', this.value)
          this.close()
        },
        /**
         * @param  {Object} obj
         * @return {String}
         */
        formatDisplay (obj) {
          switch (typeof this.results_display) {
            case 'function':
              return this.results_display(obj)
            case 'string':
              if (!obj[this.results_display]) {
                throw new Error(`"${this.results_display}" property expected on result but is not defined.`)
              }
              return obj[this.results_display]
            default:
              throw new TypeError()
          }
        },
        /**
         * Register the component as focussed
         */
        focus () {
          this.isFocussed = true
        },
        /**
         * Remove the focussed value
         */
        blur () {
          this.isFocussed = false
        },
        /**
         * Is this item selected?
         * @param {Object}
         * @return {Boolean}
         */
        isSelected (key) {
          return key === this.selectedIndex
        },
        /**
         * Focus on the previous results item
         */
        up () {
          if (this.selectedIndex === null) {
            this.selectedIndex = this.results.length - 1
            return
          }
          this.selectedIndex = (this.selectedIndex === 0) ? this.results.length - 1 : this.selectedIndex - 1
        },
        /**
         * Focus on the next results item
         */
        down () {
          if (this.selectedIndex === null) {
            this.selectedIndex = 0
            return
          }
          this.selectedIndex = (this.selectedIndex === this.results.length - 1) ? 0 : this.selectedIndex + 1
        },
        /**
         * Select an item via the keyboard
         */
        enter () {
          if (this.selectedIndex === null) {
            this.$emit('nothingSelected', this.display)
            return
          }
          this.select(this.results[this.selectedIndex])
          this.$emit('enter', this.display)
        },
        /**
         * Clear all values, results and errors
         */
        clear () {
          this.display = null
          this.value = null
          this.results = null
          this.error = null
          this.$emit('clear')
          // this.$emit('selected', [])
          // this.$emit('input', '')
        },
        /**
         * Close the results list. If nothing was selected clear the search
         */
        close () {
          if (!this.value || !this.selectedDisplay) {
            this.clear()
          }
          if (this.selectedDisplay !== this.display && this.value) {
            this.display = this.selectedDisplay
          }
          this.results = null
          this.error = null
          this.removeEventListener()
          this.$emit('close')
        },
        /**
         * Add event listener for clicks outside the results
         */
        setEventListener () {
          if (this.eventListener) {
            return false
          }
          this.eventListener = true
          document.addEventListener('click', this.clickOutsideListener, true)
          return true
        },
        /**
         * Remove the click event listener
         */
        removeEventListener () {
          this.eventListener = false
          document.removeEventListener('click', this.clickOutsideListener, true)
        },
        /**
         * Method invoked by the event listener
         */
        clickOutsideListener (event) {
          if (this.$el && !this.$el.contains(event.target)) {
            this.close()
          }
        }
      },
      mounted () {
        this.value = this.initial_value
        this.display = this.initial_display
        this.selectedDisplay = this.initial_display
      }
});
