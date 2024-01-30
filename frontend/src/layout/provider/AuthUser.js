import React, { useState, createContext, useContext, useEffect } from 'react';

const UserContext = createContext();
const UserUpdateContext = createContext();


export function useUser(){
    return useContext(UserContext);
}

export function useUserUpdate(){
  return useContext(UserUpdateContext);
}

const checkUser = (type, role) => {
  
    const admin_type = ['MSG', 'MEG', 'FSD', 'MBG']
    const user_type = ['AR INPUTER', 'AR AUTHORISER']
    
  if (type == 'user') {
      if (!user_type.includes(role)) {
        window.location.href = `${process.env.PUBLIC_URL}/admin-dashboard`;
      }
  }
  if (type == 'admin') {
      if (!admin_type.includes(role)) {
        window.location.href = `${process.env.PUBLIC_URL}/dashboard`;
      }
  }
}


const UserProvider = ({...props}) => {
    const user_data = atob(localStorage.getItem('logger'));
    const json_user = JSON.parse(user_data)
    
    const defaultUser = {
      role: localStorage.getItem('role'), 
      id: localStorage.getItem('id'), 
      email: localStorage.getItem('user_mail'),
      firstName: localStorage.getItem('firstName'),
      user_data: json_user,
      is_ar_inputter: function () {
        return localStorage.getItem('role') == "ARINPUTER" ? true : false;
      },
      is_ar_authorizer: function () {
        return localStorage.getItem('role') == "ARAUTHORISER" ? true : false;
      },
      is_admin_msg: function () {
        return localStorage.getItem('role') == "MSG" ? true : false;
      },
      is_admin_meg: function () {
        return localStorage.getItem('role') == "MEG" ? true : false;
      },
      is_admin_fsd: function () {
        return localStorage.getItem('role') == "FSD" ? true : false;
      },
      is_admin_mbg: function () {
        return localStorage.getItem('role') == "MBG" ? true : false;
      },
      is_admin_blg: function () {
        return localStorage.getItem('role') == "BLG" ? true : false;
      },
      is_position_cco: function () {
        return json_user.position.name == "CCO" ? true : false;
      },
    }
    
    const [user, setUser] = useState(defaultUser);

    checkUser(props.type, defaultUser.user_data.role.name)
    const userUpdate = {
      role : function(){
        setUser({...user, role : localStorage.getItem('role')})
      },
      id : function(){
        setUser({...user, id : localStorage.getItem('id')})
      },
      email : function(){
        setUser({...user, email : localStorage.getItem('user_mail')})
      },
      firstName : function(){
        setUser({...user, firstName : localStorage.getItem('firstName')})
      },
      user_data : function(){
        setUser({...user, user_data : JSON.parse(atob(localStorage.getItem('logger')))})
      },
      reset : function(e){
        setUser({...user, role : defaultUser.role, id: defaultUser.id, email: defaultUser.email, firstName: defaultUser.firstName })
      },
    }

  return (
    <UserContext.Provider value={user} >
      <UserUpdateContext.Provider value={userUpdate}>
        {props.children}
      </UserUpdateContext.Provider>
    </UserContext.Provider>
  )

}
export default UserProvider;