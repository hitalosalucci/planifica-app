import { ref } from 'vue';
import { windowLocation } from '../utils/globalFunctions';
import packageInfo from '../../../package.json';

export const brandData = ref({
  name: 'Planifica',
  domainUrl: windowLocation(),
  imageLogoHorizontalDark: '/images/brand/planifica-logotipo-dark.png',
  imageLogoHorizontalLight: '/images/brand/planifica-logotipo-light.png',
  imageIconogram: 'images/brand/planifica-icon.svg',
  imageBannerLogin: '/images/pages/auth/banner-login.png',
});

export const currentUserData = ref({});

export const globalPackageJsonData = ref({
  version: packageInfo.version,
});
