<script setup lang="ts">

import {reactive, computed} from 'vue'

const emit = defineEmits<{
  (e: 'clickOnPage', page: number): void
}>()

const props = defineProps<{
  lastPage: number,
}>()

const state = reactive({
  current: 1
})

const pages = computed(() => {
  if (!props.lastPage) {
    return [];
  }

  let values = [];

  let points = [1, props.lastPage, state.current]

  let skip = false;

  for (let i = 1; i <= props.lastPage; i++) {

    let newPoints = points.filter(point => i >= (point - 1) && i <= (point + 2))

    if (newPoints.length) {
      values.push(i);
      skip = false;
    } else {

      if (!skip) {
        values.push('...');
        skip = true;
      }

    }

  }

  return values;

})

let clickOnPage = (page: number) => {

  state.current = page

  emit('clickOnPage', page)
}

</script>

<template>

  <ul class="bm-pagination">

    <template v-for="page in pages">

      <li v-if="typeof page == 'number'" @click="clickOnPage(page)" :class="['bm-pagination__page', {'bm-pagination__page--active': page === state.current}]">
        {{ page }}
      </li>

      <li v-else class="bm-pagination__skip">
        {{ page }}
      </li>

    </template>

  </ul>

</template>

<style scoped>

.bm-pagination {
  display: flex;
  list-style: none;
}

.bm-pagination li {
  width: 32px;
  min-width: 32px;
  height: 32px;
  padding: 8px;
  font-size: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
}

.bm-pagination li.bm-pagination__skip {
  cursor: default;
}


.bm-pagination li.bm-pagination__page--active {
  border-bottom: 2px solid #00cca2;
  color: #00cca2;
}

</style>