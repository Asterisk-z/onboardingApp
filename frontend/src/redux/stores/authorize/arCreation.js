import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axios from "axios";
import { errorHandler, successHandler } from "utils/Functions";
import queryGenerator from "utils/QueryGenerator";
const initialState = { all: null, list: null, ar_request_list: null, msg_ar_request_list: null, mbg_ar_request_list: null, status_list: null, transfer_list: null, user: null, total: null, error: "", loading: false };





export const sendCreationRequest = createAsyncThunk(
    "arCreation/sendCreationRequest",
    async (values) => {
        
        try {
            const { data } = await axios({
                method: "post",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json;charset=UTF-8",
                    // "Content-Type": "multipart/form-data",
                },
                url: `ar/creation/request`,
                data: values,
            });
            return successHandler(data, data?.message);
        } catch (error) {
            return errorHandler(error, true);
        }
    }
);


export const getArCreationRequest = createAsyncThunk(
    "arCreation/getArCreationRequest",
    async (values) => {
        const query = queryGenerator(values);
        try {
            const { data } = await axios.get(`ar/creation/request?${query}`);
            return successHandler(data);
        } catch (error) {
            return errorHandler(error);
        }
    }
);


export const getMsgArCreationRequest = createAsyncThunk(
    "arCreation/getMsgArCreationRequest",
    async (values) => {
        const query = queryGenerator(values);
        try {
            const { data } = await axios.get(`msg/ar-creation/request?${query}`);
            return successHandler(data);
        } catch (error) {
            return errorHandler(error);
        }
    }
);


export const msgReviewArCreationRequest = createAsyncThunk(
    "arCreation/msgReviewArCreationRequest",
    async (values) => {
        
        try {
            const { data } = await axios({
                method: "post",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json;charset=UTF-8",
                    // "Content-Type": "multipart/form-data",
                },
                url: `msg/ar-creation/request/review`,
                data: values,
            });
            return successHandler(data, data?.message);
        } catch (error) {
            return errorHandler(error, true);
        }
    }
);


export const getMbgArCreationRequest = createAsyncThunk(
    "arCreation/getMbgArCreationRequest",
    async (values) => {
        const query = queryGenerator(values);
        try {
            const { data } = await axios.get(`mbg/ar-creation/request?${query}`);
            return successHandler(data);
        } catch (error) {
            return errorHandler(error);
        }
    }
);



export const mbgReviewArCreationRequest = createAsyncThunk(
    "arCreation/mbgReviewArCreationRequest",
    async (values) => {
        
        try {
            const { data } = await axios({
                method: "post",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json;charset=UTF-8",
                    // "Content-Type": "multipart/form-data",
                },
                url: `mbg/ar-creation/request/review`,
                data: values,
            });
            return successHandler(data, data?.message);
        } catch (error) {
            return errorHandler(error, true);
        }
    }
);


const arCreationStore = createSlice({
    name: "arCreation",
    initialState,
    reducers: {
        clearArUser: (state) => {
            state.customer = null;
            state.search_list = null
        },
    },
    extraReducers: (builder) => {

        // ====== builders for sendCreationRequest ======

        builder.addCase(sendCreationRequest.pending, (state) => {
            state.loading = true;
        });

        builder.addCase(sendCreationRequest.fulfilled, (state, action) => {
            state.loading = false;
        });

        builder.addCase(sendCreationRequest.rejected, (state, action) => {
            state.loading = false;
            state.error = action.payload?.message;
        });

        // ====== builders for mbgReviewArCreationRequest ======

        builder.addCase(mbgReviewArCreationRequest.pending, (state) => {
            state.loading = true;
        });

        builder.addCase(mbgReviewArCreationRequest.fulfilled, (state, action) => {
            state.loading = false;
        });

        builder.addCase(mbgReviewArCreationRequest.rejected, (state, action) => {
            state.loading = false;
            state.error = action.payload?.message;
        });


        // ====== builders for msgReviewArCreationRequest ======

        builder.addCase(msgReviewArCreationRequest.pending, (state) => {
            state.loading = true;
        });

        builder.addCase(msgReviewArCreationRequest.fulfilled, (state, action) => {
            state.loading = false;
        });

        builder.addCase(msgReviewArCreationRequest.rejected, (state, action) => {
            state.loading = false;
            state.error = action.payload?.message;
        });

        // ====== builders for getArCreationRequest ======

        builder.addCase(getArCreationRequest.pending, (state) => {
            state.loading = true;
        });

        builder.addCase(getArCreationRequest.fulfilled, (state, action) => {
            state.loading = false;
            // state.list = action.payload?.data?.data?.categories;
            state.ar_request_list = JSON.stringify(action.payload?.data?.data);
        });

        builder.addCase(getArCreationRequest.rejected, (state, action) => {
            state.loading = false;
            state.error = action.payload.message;
        });

        // ====== builders for getMsgArCreationRequest ======

        builder.addCase(getMsgArCreationRequest.pending, (state) => {
            state.loading = true;
        });

        builder.addCase(getMsgArCreationRequest.fulfilled, (state, action) => {
            state.loading = false;
            // state.list = action.payload?.data?.data?.categories;
            state.msg_ar_request_list = JSON.stringify(action.payload?.data?.data);
        });

        builder.addCase(getMsgArCreationRequest.rejected, (state, action) => {
            state.loading = false;
            state.error = action.payload.message;
        });
        
        
        // ====== builders for getMbgArCreationRequest ======

        builder.addCase(getMbgArCreationRequest.pending, (state) => {
            state.loading = true;
        });

        builder.addCase(getMbgArCreationRequest.fulfilled, (state, action) => {
            state.loading = false;
            // state.list = action.payload?.data?.data?.categories;
            state.mbg_ar_request_list = JSON.stringify(action.payload?.data?.data);
        });

        builder.addCase(getMbgArCreationRequest.rejected, (state, action) => {
            state.loading = false;
            state.error = action.payload.message;
        });

    },
});

export default arCreationStore.reducer;
export const { clearArUser } = arCreationStore.actions;