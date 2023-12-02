import React from 'react'
import Logo from "../../images/fmdq/FMDQ-Logo.png"
import './HeaderLogo.css'

export const HeaderLogo = () => {
  return (
    <header>
        <div>
            <img src={Logo} alt="logo"/>
        </div>
        <div>
            <h4>MROIS</h4>
        </div>
    </header>
  )
}
