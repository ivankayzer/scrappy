const router = (() => {
  const routes = {
    "/login": {
      user: {
        email: "ivankayzer@gmail.com",
      },
    },
  };

  const getRoute = (path) => routes[path];

  const timeout = 600;

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

  const errorPromise = () =>
    new Promise((_, reject) => {
      setTimeout(() => {
        reject({
          error: "Request was unsuccessful",
        });
      }, timeout);
    });

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
