import { configureStore } from "@reduxjs/toolkit";

const store = configureStore({
  reducer: {

  },
  middleware: (getDefaultMiddleware) =>
    getDefaultMiddleware({
      serializableCheck: {
        // Ignore these action types
        ignoredActions: [
          
        ],
      },
    }).concat(),
});

export default store;
