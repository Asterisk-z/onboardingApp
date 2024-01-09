import React, { useState } from "react";
import DatePicker from "react-multi-date-picker"
import DatePanel from "react-multi-date-picker/plugins/date_panel"

const MultiDatePicker = ({ id }) => {
  
  const [values, setValues] = useState([])

  return (
    <React.Fragment>
      <DatePicker  className="form-control" id="form-control"
        multiple
        value={values} 
        onChange={setValues}
          plugins={[
          <DatePanel />
          ]}
      />
    </React.Fragment>
  );
};

export default MultiDatePicker;
