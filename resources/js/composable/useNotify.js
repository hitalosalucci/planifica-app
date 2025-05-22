import { useQuasar } from "quasar";

export default function useNotify() {
  const $q = useQuasar();

  const notifySuccess = (message, position = "bottom-right") => {
    $q.notify({
      message: message,
      html: true,
      classes: "bg-success-notify",
      position,
      avatar: "/svg/verify-notify.svg",
      actions: [
        {
          icon: "close",
          color: "green-6",
          round: true,
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
      avatar: "/svg/error-notify-round.svg",
      actions: [
        {
          icon: "close",
          color: "red-5",
          round: true,
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
      avatar: "/svg/notify-warning.svg",
      actions: [
        {
          icon: "close",
          color: "yellow-9",
          round: true,
          handler: () => {
            /* ... */
          },
        },
      ],
    });
  };

  const notifyAlert = (message, position, icon) => {
    $q.notify({
      message: message,
      html: true,
      position,
      classes: "sci-alert-notify",
      icon: icon || "mood_bad",
      textColor: "yellow-9",
      actions: [
        {
          icon: "close",
          color: "yellow-9",
          round: true,
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
      avatar: "/svg/warning-info.svg",
      actions: [
        {
          icon: "close",
          color: "blue-5",
          round: true,
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
    notifyInfo,
    notifyAlert,
  };
}
