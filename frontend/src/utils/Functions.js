import { toast } from "react-toastify";
import { Icon } from "../components/Component";

// remove all falsy property from  object
export function removeFalsyProperties(obj) {
  const newObj = {};
  for (const prop in obj) {
    if (obj.hasOwnProperty(prop) && obj[prop]) {
      newObj[prop] = obj[prop];
    }
  }
  return newObj;
}

export function stringShorter(str, length) {
  return str?.length > length ? str.slice(0, length) + "..." : str;
}

export function errorHandler(error, toastStatus, messageType = "Error") {
  if (error.response?.data?.error) {
    //   toastStatus && toast.error(error.response.data.error);
    toast.error(<div className="toastr-text"><h5>{`${messageType}`}</h5><p>{`${error.response.data.error}`}</p></div>, {
      position: "top-right",
      autoClose: true,
      hideProgressBar: true,
      closeOnClick: true,
      pauseOnHover: true,
      draggable: true,
      progress: false,
      closeButton: <span className="btn-trigger toast-close-button" role="button"><Icon name="cross"></Icon></span>,
    });
    return {
      message: "error",
      error: error.response.data.error,
    };
  } else {
    //   toastStatus && toast.warning("Something went wrong, Please try again");
        toast.warning(<div className="toastr-text"><h5>{`${"Warning"}`}</h5><p>{`${"Something went wrong, Please try again"}`}</p></div>, {
            position: "top-right",
            autoClose: true,
            hideProgressBar: true,
            closeOnClick: true,
            pauseOnHover: true,
            draggable: true,
            progress: false,
            closeButton: <span className="btn-trigger toast-close-button" role="button"><Icon name="cross"></Icon></span>,
        });
    return {
      message: "error",
      error: "Something went wrong, Please try again",
    };
  }
}


export function successHandler(data, message, messageType = "Success") {

    if (message) {
        toast.success(<div className="toastr-text"><h5>{`${messageType}`}</h5><p>{`${message}`}</p></div>, {
            position: "top-right",
            autoClose: false,
            hideProgressBar: true,
            closeOnClick: true,
            pauseOnHover: true,
            draggable: true,
            progress: false,
            closeButton: <span className="btn-trigger toast-close-button" role="button"><Icon name="cross"></Icon></span>,
        });
        
    }

//   message && toast[messageType](message);
    return {
        message: "success",
        data,
    };
}
