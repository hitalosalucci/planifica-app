import { useQuasar } from "quasar";

export default function useNotify() {
  const $q = useQuasar();

  const notifySuccess = (message, position = "bottom-right") => {
    $q.notify({
      message: message,
      html: true,
      classes: "bg-success-notify",
      position,
      actions: [
        {
          icon: "close",
          color: "green-6",
          rounded: true,
          handler: () => {
            /* ... */
          },
        },
      ],
    });
  };

  const notifyError = (message, position = "bottom-right") => {
    $q.notify({
      message: message,
      html: true,
      classes: "bg-error-notify",
      position,
      actions: [
        {
          icon: "close",
          color: "red-5",
          rounded: true,
          handler: () => {
            /* ... */
          },
        },
      ],
    });
  };

  const notifyWarning = (message, position = "bottom-right") => {
    $q.notify({
      message: message,
      html: true,
      classes: "bg-warning-notify",
      position,
      actions: [
        {
          icon: "close",
          color: "yellow-9",
          rounded: true,
          handler: () => {
            /* ... */
          },
        },
      ],
    });
  };

  const notifyInfo = (message, position = "bottom-right") => {
    $q.notify({
      html: true,
      message: message,
      classes: "bg-info-notify",
      position,
      actions: [
        {
          icon: "close",
          color: "blue-5",
          rounded: true,
          handler: () => {
            /* ... */
          },
        },
      ],
    });
  };

  return {
    notifySuccess,
    notifyError,
    notifyWarning,
    notifyInfo
  };
}
