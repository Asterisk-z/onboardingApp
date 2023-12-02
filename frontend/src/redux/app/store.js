import { configureStore } from "@reduxjs/toolkit";
import authenticateReducer from "../stores/authenticate/authStore";

const store = configureStore({
  reducer: {
    authenticate: authenticateReducer,
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
