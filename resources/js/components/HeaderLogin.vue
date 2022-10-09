<script setup lang="ts">

import {computed, defineComponent, inject, onMounted, reactive} from 'vue'
import {AxiosResponse, AxiosError, AxiosStatic} from "axios";
import ErrorMessages from "./ErrorMessages.vue";
import {OnClickOutside} from '@vueuse/components'

const $axios = inject('$axios') as AxiosStatic;

const state = reactive({
  authStateLoaded: false,
  showLoginForm: false,
  userEmail: '',
  form: {
    email: '',
    password: ''
  },
  validationErrors: {},
  signInError: ''
})

onMounted(() => {
  getProfile()
})

const toggleLogin = () => {
  state.showLoginForm = !state.showLoginForm
}

const handleFocusOut = () => {
  state.showLoginForm = false
}

const getProfile = () => {
  $axios.get('/user/profile').then((response: AxiosResponse) => {
    state.userEmail = response.data.data.user.email
  }).catch((error: AxiosError) => {
  }).finally(() => {
    state.authStateLoaded = true;
  })
}

const signIn = () => {

  state.signInError = '';
  state.validationErrors = {};

  $axios.post('/sign-in', state.form).then((response: AxiosResponse) => {

    if (response.data.status === 'success') {
      state.userEmail = response.data.data.email;
    } else {
      state.signInError = response.data.message
    }

  }).catch((error: AxiosError) => {

    if (error.response?.data.errors) {
      state.validationErrors = error.response?.data.errors
    }

  })
}

const logout = () => {
  $axios.post('/sign-out').then((response: AxiosResponse) => {

    state.userEmail = '';

    console.log(response)

  }).catch((error: AxiosError) => {

    console.log(error.response)

  })
}

</script>

<template>
  <OnClickOutside @trigger="handleFocusOut">
    <div v-if="state.authStateLoaded" @click-outside="" tabindex="0">

      <div class="header__user" v-if="state.userEmail">
        <span>{{ state.userEmail }}</span>
        <div class="header-logout" @click="logout"></div>
      </div>

      <div class="header__login" v-else>
        <div class="button button--primary-outline header__sign-in mr-8" @click="toggleLogin">Sign in</div>

        <div class="bm-form-glue  mr-8">or</div>

        <a class="bm-link" href="">register</a>

      </div>

      <div class="compact-card login-card" v-cloak v-if="!state.userEmail" v-show="state.showLoginForm">

        <div class="compact-card__header">
          Sign in
        </div>

        <ErrorMessages :error=state.signInError :validation-errors=state.validationErrors></ErrorMessages>

        <div class="bm-form-group">

          <div class="bm-label">Your username (e-mail)</div>

          <div class="bm-input-group">

            <div class="bm-input-prepend">
              <svg viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.1801 19.738H15.1801C15.1801 16.364 12.3501 13.62 8.86908 13.62C5.38808 13.62 2.55908 16.365 2.55908 19.738H0.559082C0.559082 15.26 4.28808 11.62 8.87008 11.62C13.4511 11.62 17.1801 15.26 17.1801 19.738Z" fill="#00CCA2"/>
                <path d="M8.87008 10.97C5.84708 10.97 3.38608 8.508 3.38608 5.485C3.38508 2.461 5.84608 0 8.87008 0C11.8951 0 14.3561 2.46 14.3561 5.485C14.3561 8.51 11.8951 10.97 8.87008 10.97ZM8.87008 2C6.94808 2 5.38508 3.563 5.38508 5.485C5.38508 7.407 6.94808 8.97 8.87008 8.97C10.7931 8.97 12.3561 7.407 12.3561 5.485C12.3561 3.563 10.7911 2 8.87008 2Z" fill="#00CCA2"/>
              </svg>
            </div>

            <input type="text" class="bm-input-text bm-input-text--long" name="email" v-model="state.form.email">

          </div>
        </div>

        <div class="bm-form-group">

          <div class="bm-label">Password</div>

          <div class="bm-input-group">

            <div class="bm-input-prepend">
              <svg viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.0714 13.0714C12.4659 13.0714 12.7857 12.7516 12.7857 12.3571C12.7857 11.9627 12.4659 11.6429 12.0714 11.6429C11.6769 11.6429 11.3571 11.9627 11.3571 12.3571C11.3571 12.7516 11.6769 13.0714 12.0714 13.0714Z" fill="#00CCA2"/>
                <path d="M15.2857 12.9286C15.6802 12.9286 16 12.6088 16 12.2143V9.57143C16 7.996 14.7183 6.71429 13.1429 6.71429H12.2844V4.19521C12.2844 1.88196 10.3618 0 7.99868 0C5.63554 0 3.71296 1.88196 3.71296 4.19521V6.71429H2.85714C1.28171 6.71429 0 7.996 0 9.57143V15.4286C0 17.004 1.28171 18.2857 2.85714 18.2857H13.1429C14.7183 18.2857 16 17.004 16 15.4286C16 15.0341 15.6802 14.7143 15.2857 14.7143C14.8912 14.7143 14.5714 15.0341 14.5714 15.4286C14.5714 16.2163 13.9306 16.8571 13.1429 16.8571H2.85714C2.06943 16.8571 1.42857 16.2163 1.42857 15.4286V9.57143C1.42857 8.78371 2.06943 8.14286 2.85714 8.14286H13.1429C13.9306 8.14286 14.5714 8.78371 14.5714 9.57143V12.2143C14.5714 12.6088 14.8912 12.9286 15.2857 12.9286ZM10.8558 6.71429H5.14154V4.19521C5.14154 2.66968 6.42325 1.42857 7.99868 1.42857C9.57411 1.42857 10.8558 2.66968 10.8558 4.19521V6.71429Z" fill="#00CCA2"/>
                <path d="M6.67857 13.0714C7.07306 13.0714 7.39286 12.7516 7.39286 12.3571C7.39286 11.9627 7.07306 11.6429 6.67857 11.6429C6.28408 11.6429 5.96429 11.9627 5.96429 12.3571C5.96429 12.7516 6.28408 13.0714 6.67857 13.0714Z" fill="#00CCA2"/>
                <path d="M4 13.0714C4.39449 13.0714 4.71429 12.7516 4.71429 12.3571C4.71429 11.9627 4.39449 11.6429 4 11.6429C3.60551 11.6429 3.28571 11.9627 3.28571 12.3571C3.28571 12.7516 3.60551 13.0714 4 13.0714Z" fill="#00CCA2"/>
                <path d="M9.35714 13.0714C9.75163 13.0714 10.0714 12.7516 10.0714 12.3571C10.0714 11.9627 9.75163 11.6429 9.35714 11.6429C8.96265 11.6429 8.64286 11.9627 8.64286 12.3571C8.64286 12.7516 8.96265 13.0714 9.35714 13.0714Z" fill="#00CCA2"/>
              </svg>
            </div>

            <input type="password" name="password" class="bm-input-text bm-input-text--long" v-model="state.form.password">

          </div>
        </div>

        <div class="bm-button-group bm-button-group--line bm-button-group--center mt-32">

          <button class="button button--primary  mr-16" type="submit" @click="signIn">
            Sign in
          </button>

          <!--      <div class="bm-form-glue mr-16">-->
          <!--        or use-->
          <!--      </div>-->

          <!--      <a href="#" class="button button&#45;&#45;primary-outline button&#45;&#45;xs bm-button&#45;&#45;google-outline button&#45;&#45;xs&#45;&#45;with-icon mr-16">Google</a>-->
          <!--      <a href="#" class="button button&#45;&#45;primary-outline button&#45;&#45;xs bm-button&#45;&#45;facebook-outline button&#45;&#45;xs&#45;&#45;with-icon">Facebook</a>-->

        </div>

      </div>

    </div>
  </OnClickOutside>
</template>