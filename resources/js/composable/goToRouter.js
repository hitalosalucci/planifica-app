import { useRouter } from "vue-router";
export function useGoToRouter() {
  const router = useRouter();

  const handleGoToPage = (route) => {
    router.push({ name: route });
  };

  const handleGotoLoginLocation = () => {
    location.replace("/");
  };

  const handleGoToPageParams = (route, params) => {
    router.push({ name: route, params });
  };

  const handleGoToPageParamsReplace = (route, params) => {
    router.replace({ name: route, params });
  };

  const handleGotoLocation = (url, isBlank) => {
    if (isBlank) {
      // Se o URL estiver em branco, abre em uma nova guia
      window.open(url, "_blank");
    } else {
      // Caso contrário, substitui a página atual
      location.replace(url);
    }
  };

  const handleGoToPageReplace = (route) => {
    router.replace(`/${route}`);
  };

  return {
    handleGoToPage,
    handleGotoLoginLocation,
    handleGoToPageParams,
    handleGoToPageParamsReplace,
    handleGotoLocation,
    handleGoToPageReplace,
  };
}
