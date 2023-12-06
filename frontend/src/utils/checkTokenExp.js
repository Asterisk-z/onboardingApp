import React from "react";
import { useNavigate } from 'react-router-dom';

const checkTokenExp = (token, user) => {
  try {
    const navigate = useNavigate()
    if(!token || !user ) {
        navigate(`${process.env.PUBLIC_URL}/logout`);
    }
    const decoded = token.split('.')[1]
    const de = atob(decoded)
    const deOject = JSON.parse(de);

    if (deOject.exp * 1000 < Date.now()) {
        navigate(`${process.env.PUBLIC_URL}/logout`);
    }

  } catch (error) {
        navigate(`${process.env.PUBLIC_URL}/logout`);
  }
};

export default checkTokenExp;
