import { configureStore } from "@reduxjs/toolkit";
import authenticateReducer from "../stores/authenticate/authStore";
import categoryReducer from "../stores/memberCategory/category";
import countryReducer from "../stores/nationality/country";
import complaintReducer from "../stores/complaints/complaint";
import complaintTypeReducer from "../stores/complaints/complaintTypes";
import activityReducer from "../stores/activity/audit";
import arUsersReducer from "../stores/authorize/representative";
import roleStore from "../stores/roles/roleStore";
import positionStore from "../stores/positions/positionStore";

const store = configureStore({
  reducer: {
    authenticate: authenticateReducer,
    category: categoryReducer,
    country: countryReducer,
    complaint: complaintReducer,
    complaintType: complaintTypeReducer,
    activity: activityReducer,
    arUsers: arUsersReducer,
    role: roleStore,
    position: positionStore,
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
