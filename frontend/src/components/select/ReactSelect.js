import React from "react";
import Select,  { components } from "react-select";

const RSelect = ({ ...props }) => {
  return (
    <div className="form-control-select">
      <Select
        className={`react-select-container ${props.className ? props.className : ""}`}
        classNamePrefix="react-select"
        {...props}
      />
    </div>
  );
};

export default RSelect;
