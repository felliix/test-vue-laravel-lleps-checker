<template>
  <div class="grid-container">
    <div class="grid-x">
      <div class="cell banner">
        <span class="banner-title">Spell Checker 101</span>
      </div>
    </div>

    <div class="grid-x form-panel grid-padding-x">
      <div class="cell small-12 medium-8">
        <form @submit.prevent="onSubmit">
          <div class="grid-x grid-padding-x">
            <div class="cell small-12 large-4">
              <label for="list-items">List Items</label>
              <select id="list-items" v-model="selectedWord">
                <option disabled value="">Please select</option>
                <option v-for="(w, i) in words" :value="w" :key="i">{{ w }}</option>
              </select>
            </div>

            <div class="cell small-12 large-4">
              <label for="offset-diff-value">Offset Diff Value</label>
              <input
                id="offset-diff-value"
                v-model.number="offsetDiff"
                type="number"
                min="0"
                max="99"
                placeholder="Max match no" />
            </div>

            <div class="cell small-12 large-4">
              <label for="to-check-value">To Check Value</label>
              <input
                id="to-check-value"
                v-model="checkValue"
                type="text"
                placeholder="Enter value to check" />
            </div>
          </div>

          <div class="grid-x grid-padding-x">
            <div class="cell small-12 large-4">
              <button class="button expanded" :disabled="disableSubmit">Go</button>
            </div>
          </div>
        </form>
      </div>

      <div class="cell small-12 medium-4">
        <label>All List Items</label>
        <ul>
          <li v-for="(w, i) in words" :key="i" :class="{ submitted: history.includes(i) }">{{ w }}</li>
        </ul>
      </div>

    </div>
  </div>
</template>

<style scoped lang="scss">
  @import './spellChecker.scss';
</style>

<script>
  import axios from 'axios';

  export default {
    data() {
      return {
        words: [
          'Github',
          'onomatopoeia',
          'repository',
          'cloud server',
          'tennessee',
          'big orange',
          'chattanooga'
        ],
        offsetDiff: 0,
        selectedWord: "",
        checkValue: "",
        fetching: false,
        history: []

      }
    },
    computed: {
      disableSubmit() {
        return this.fetching || !this.selectedWord || this.checkValue.length === 0;
      }
    },
    methods: {
      onSubmit() {
        this.fetching = true;
        axios.post(
          '/check-word',
          {
            offsetDiff: this.offsetDiff,
            selectedWord: this.selectedWord,
            checkValue: this.checkValue
          }
        ).then(response => {
          this.fetching = false;
          this.history.push(this.words.indexOf(this.selectedWord));
          alert(response.data.desc);
        })
      }
    }
  }
</script>
