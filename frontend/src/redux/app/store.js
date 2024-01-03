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
import userStore from "../stores/users/userStore";
import broadcastStore from "../stores/broadcast/broadcastStore";
import settingStore from "../stores/settings/config";
import institutionStore from "../stores/institution/institutionStore";
import regulatorStore from "redux/stores/regulators/regulatorStore";
import sanctionStore from "redux/stores/sanctions/sanctionStore";
import applicationStore from "redux/stores/membership/applicationStore"
import feesAndDuesStore from "redux/stores/feesAndDues/feesAndDuesStore";

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
    user: userStore,
    broadcasts: broadcastStore,
    settings: settingStore,
    institutions: institutionStore,
    regulator: regulatorStore,
    sanctions: sanctionStore,
    application: applicationStore,
    fees: feesAndDuesStore,
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
