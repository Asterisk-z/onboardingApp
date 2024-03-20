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

  if (error.response.status == 401) {
    return;
  }
  
  const errors = error.response?.data?.errors ? error.response?.data?.errors : null;
  const errorMessage = (typeof errors === 'object') ? Object.values(errors)[0][0] : "";
  // console.log(error)
  if (error.response?.data?.message) {
      // console.log("first")
      toast.error(<div className="toastr-text"><h5>{`${messageType}`}</h5><p>{`${error.response.data.message}  -  ${errorMessage}`}</p></div>)
      
      return {
        message: error,
        error: error.response.data.error,
      };
  } else {
      // console.log("second")
    
        toast.warning(<div className="toastr-text"><h5>{`${"Warning"}`}</h5><p>{`${"Something went wrong, Please try again"}`}</p></div>)

    return {
      message: error,
      error: "Something went wrong, Please try again",
    };
  }
}


export function successHandler(data, message, messageType = "Success") {

    if (message) {
        toast.success(<div className="toastr-text"><h5>{`${messageType}`}</h5><p>{`${message}`}</p></div>)
        
    }
    return {
        message: "success",
        data,
    };
}
