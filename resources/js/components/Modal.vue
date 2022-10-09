<script setup lang="ts">

const emit = defineEmits(['close'])

const props = defineProps({
  open: Boolean
})

const close = () => emit('close')

</script>

<template>
  <Transition name="modal" v-if="open">
    <div class="modal-mask" @click="close">
      <div class="modal-wrapper">
        <div class="modal-container" @click.stop="">
          <div class="modal-content">
            <slot name="content"></slot>
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<style>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 760px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  position: relative;
}


.uu-modal-title {
  border-bottom: 1px solid #cbd5e0;
  font-size: 18px;
  font-weight: 500;
  padding: 0 0 16px 0;
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 16px;
}

.modal-content {
  padding: 0;
}

.uu-modal__close {
  position: absolute;
  right: 28px;
  top: 24px;
  cursor: pointer;
  width: 16px;
  height: 16px;
  background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-lg' viewBox='0 0 16 16'%3E %3Cpath d='M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z'/%3E%3C/svg%3E") no-repeat center center;
}
</style>