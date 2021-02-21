const router = (() => {
  const routes = {
    "/login": {
      user: {
        email: "ivankayzer@gmail.com",
      },
    },
  };

  const router = (path) => {
    return routes[path];
  };

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

  const errorPromise = () => {
    return new Promise((_, reject) => {
      setTimeout(() => {
        reject({
          error: "Request was unsuccessful",
        });
      }, timeout);
    });
  };

  return {
    error: () => errorPromise(),
    get: (path) => successPromise(router(path)),
    post: (path) => successPromise(router(path)),
    put: (path) => successPromise(router(path)),
    patch: (path) => successPromise(router(path)),
    delete: (path) => successPromise(router(path)),
  };
})();

export default router;
