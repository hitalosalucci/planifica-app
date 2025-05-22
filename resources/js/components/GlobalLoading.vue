<script>
import { useQuasar, QSpinnerFacebook } from 'quasar'
import { onBeforeUnmount } from 'vue'

export default {
  setup () {
    const $q = useQuasar()
    let timer

    onBeforeUnmount(() => {
      if (timer !== void 0) {
        clearTimeout(timer)
        $q.loading.hide()
      }
    })

    return {
      showLoading () {
        $q.loading.show({
          spinner: QSpinnerFacebook,
          spinnerColor: 'yellow',
          spinnerSize: 120,
          backgroundColor: 'white',
        })

        // hiding in 3s
        timer = setTimeout(() => {
          $q.loading.hide()
          timer = void 0
        }, 3000)
      }
    }
  }
}
</script>