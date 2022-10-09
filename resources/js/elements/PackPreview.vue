<script setup lang="ts">

const props = defineProps<{
  pack: Pack,
}>()

</script>

<template>

  <a :href="pack.url" class="pack">

    <div :class="`pack__assets pack__assets--${pack.type}`">
      <div v-for="asset in pack.preview_assets" :class="`pack__asset pack-${pack.type}-preview`">
        <img :src="pack.type === 'icon' ? asset.preview_86 : asset.preview_320" :alt="asset.name">
      </div>
    </div>

    <div class="pack__name">
      {{pack.name}}
    </div>

    <div class="pack__info">

      <div class="pack__count">
        {{pack.count_assets_text}}
      </div>

      <div class="pack__price">
        from <span class="pack-price-value">${{pack.price_personal}}</span>
        <span class="pack-price-discount">save {{pack.discount_percent}}%</span>
      </div>

    </div>

  </a>

</template>