const router = (() => {
  let events = [
    {
      name: "Page checked successfully",
      isImportant: false,
      timestamp: "15 minutes ago",
      color: "blue",
    },
    {
      name: "An error occurred during page check",
      subtext: "Trying to get property of non-object. #10193",
      isImportant: true,
      timestamp: "15 minutes ago",
      color: "red",
    },
    {
      name: "Notification sent to Telegram",
      isImportant: false,
      timestamp: "15 minutes ago",
      color: "blue",
    },
    {
      name: "Page content changed",
      changes: [
        {
          old: "Price: 2499,00 PLN",
          new: "Price: 2799,00 PLN",
        },
      ],
      isImportant: true,
      timestamp: "15 minutes ago",
      color: "green",
    },
    {
      name: "Page checked successfully",
      isImportant: false,
      timestamp: "15 minutes ago",
      color: "blue",
    },
  ];

  events = [...events, ...events, ...events];

  const tasks = [
    {
      id: 1,
      name: "RTV EURO AGD - PS5",
      url:
        "https://www.euro.com.pl/konsole-playstation-5/sony-konsola-playstation-5-ps5-blu-ray-4k.bhtml",
      isActive: true,
      lastChecked: "30 seconds ago",
      checkFrequency: "every minute",
      notificationChannel: "telegram",
      needsAttention: false,
      events,
    },
    {
      id: 2,
      name: "MediaMarkt - PS5",
      url: "https://mediamarkt.pl/konsole-i-gry/playstation-5",
      isActive: true,
      lastChecked: "30 seconds ago",
      checkFrequency: "every 30 minutes",
      notificationChannel: "telegram",
      needsAttention: true,
      events,
    },
    {
      id: 3,
      name: "PS5 - MediaExpert",
      url: "https://www.mediaexpert.pl/gaming/playstation-5/konsole-ps5",
      isActive: false,
      lastChecked: "30 seconds ago",
      checkFrequency: "every day",
      notificationChannel: "telegram",
      needsAttention: false,
      events,
    },
    {
      id: 4,
      name: "XKOM - Playstation 5",
      url:
        "https://www.x-kom.pl/p/577878-konsola-playstation-sony-playstation-5.html",
      isActive: true,
      lastChecked: "30 seconds ago",
      checkFrequency: "every minute",
      notificationChannel: "telegram",
      needsAttention: false,
      events,
    },
  ];

  const random = (arr) => arr[Math.floor(Math.random() * arr.length)];

  const routes = {
    "/login": {
      user: {
        email: "ivankayzer@gmail.com",
      },
    },
    "/tasks": tasks,
    "/events": events.map((event) => {
      const taskName = random(tasks).name;

      return {
        ...event,
        taskName,
      };
    }),
  };

  const getRoute = (path) => routes[path];

  const timeout = 600;

  const errorPromise = () =>
    new Promise((_, reject) => {
      setTimeout(() => {
        reject(new Error("Request was unsuccessful"));
      }, timeout);
    });

  const successPromise = (response) => {
    if (!response) {
      return errorPromise();
    }

    return new Promise((resolve, _) => {
      setTimeout(() => {
        resolve(response);
      }, timeout);
    });
  };

  return {
    error: () => errorPromise(),
    get: (path) => successPromise(getRoute(path)),
    post: (path) => successPromise(getRoute(path)),
    put: (path) => successPromise(getRoute(path)),
    patch: (path) => successPromise(getRoute(path)),
    delete: (path) => successPromise(getRoute(path)),
  };
})();

export default router;
