<script setup lang="ts">

import {inject, onMounted, reactive, shallowReactive} from "vue";
import {AxiosResponse, AxiosStatic} from "axios";
import BmPagination from "@/components/Pagination.vue";
import PackPreview from "@/elements/PackPreview.vue";

const $axios = inject('$axios') as AxiosStatic;

const props = defineProps<{
  family: Family
}>()

const state: {
  familiesLoaded: boolean,
  packsLoaded: boolean,
  familiesPaginator: Paginator<Family>,
  packsPaginator: Paginator<Pack>,
}
    = reactive({
  familiesLoaded: false,
  packsLoaded: false,
  familiesPaginator: {data: []},
  packsPaginator: {data: []},
})

onMounted(() => {
  loadAssets(1)
  loadPacks(1)
})

const loadAssets = (page: number = 1) => {

  $axios.get('/api/assets/', {params: {family_id: props.family.id, page: page}})
      .then((response: AxiosResponse) => {
        state.familiesPaginator = response.data as Paginator<Family>;
        state.familiesLoaded = true;
      })
}

const loadPacks = (page: number = 1) => {
  $axios.get('/api/packs/', {params: {family_id: props.family.id, page: page}})
      .then((response: AxiosResponse) => {
        state.packsPaginator = response.data as Paginator<Pack>;
        state.packsLoaded = true;
      })
}

const previewUrl = (asset: Asset) => {
  if (asset.type === 'illustration') {
    return asset.preview_url_w512
  } else {
    return asset.preview_url_w128
  }
}

</script>

<template>

  <template v-if="state.familiesLoaded">

    <div class="assets-title">
      {{ state.familiesPaginator.meta.total }} {{ family.type_plural }}
    </div>

    <div :class="props.family.type_plural" id="family-assets">
      <a v-for="asset in state.familiesPaginator.data" :href="asset.url_show" :class="asset.type + '-preview'">
        <img :src="previewUrl(asset)" :alt="asset.name">
      </a>
    </div>

    <div class="family-pagination">
      <BmPagination @click-on-page="loadAssets" :last-page="state.familiesPaginator.meta.last_page"></BmPagination>
    </div>

  </template>

  <div v-else class="bm-loading"><div></div><div></div><div></div><div></div></div>

  <template v-if="state.packsLoaded">

    <div class="assets-title packs-title">
      {{ state.packsPaginator.meta.total }} packs in this family:
    </div>

    <div class="packs">
      <PackPreview v-for="pack in state.packsPaginator.data" :pack="pack"></PackPreview>
    </div>

    <div class="family-pagination">
      <BmPagination @click-on-page="loadPacks" :last-page="state.packsPaginator.meta.last_page"></BmPagination>
    </div>

  </template>

</template>

<style scoped>

.family-pagination {
  display: flex;
  justify-content: center;
}

</style>
