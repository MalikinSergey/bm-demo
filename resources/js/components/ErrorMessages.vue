<script setup lang="ts">

import {computed} from 'vue'

const props = defineProps({
  validationErrors: {type: Object, required: false},
  error: {type: String, required: false}
})

const hasValidationErrors = computed((): boolean => {
    return Boolean((Object.keys(props.validationErrors as object).length))
})

</script>

<template>

  <div class="bm-errors bm-errors--validation" v-if="hasValidationErrors">
    <div v-for="validationError in props.validationErrors">
      <p v-for="validationErrorLine in validationError">{{ validationErrorLine }}</p>
    </div>
  </div>

  <div class="bm-errors bm-errors--single" v-if="props.error">
    <p>{{ error }}</p>
  </div>

</template>