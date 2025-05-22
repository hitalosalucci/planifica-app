import { ref } from 'vue';

const isLoading = ref(false);

export default function useGlobalLoading() {
  const showGlobalLoading = () => {
    isLoading.value = true;
  };
  const hideGlobalLoading = () => {
    isLoading.value = false;
  };

  return {
    isLoading,
    showGlobalLoading,
    hideGlobalLoading,
  };
}
