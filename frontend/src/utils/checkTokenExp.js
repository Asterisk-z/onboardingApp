// import jwt_decode from "jwt-decode";

const checkTokenExp = (token) => {
  try {
    // let amoth = ``;
    const decoded = token.split('.')[1]
    const de = atob(decoded)

    console.log(de);
    // if (jwtDecode(token).exp * 1000 < Date.now()) {
    //   if (customer) {
    //     return (window.location.href = "customer/logout");
    //   } else {
    //     return (window.location.href = "/admin/auth/logout");
    //   }
    // } else {
    // }
  } catch (error) {
  }
};

export default checkTokenExp;
