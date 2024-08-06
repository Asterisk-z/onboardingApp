import moment from "moment";
import React, { useState } from "react";
import DatePicker from "react-multi-date-picker"
import DatePanel from "react-multi-date-picker/plugins/date_panel"
// import moment from "moment";

const MultiDatePicker = ({ id, nameAttr, changeAction, max = "", properties }) => {

  const [values, setValues] = useState([])
  const [inputName, setInputName] = useState(nameAttr)

  const today = new Date()
  const tomorrow = new Date(today)
  tomorrow.setDate(tomorrow.getDate() + 1)

  const [min, setMin] = useState(tomorrow)
  // const [maxDate, setMaxDate] = useState(new Date(max))
  // minDate={minDate}
  // maxDate={maxDate}
  // console.log(values)
  // console.log(max)
  // console.log(moment(max).add(1, 'days').format('ddd MMM DD YYYY HH:mm:ss [GMT]ZZ [(West Africa Standard Time)]'))

  const maxTomorrow = new Date(max)
  maxTomorrow.setDate(maxTomorrow.getDate() + 1)

  return (
    <React.Fragment>
      <DatePicker inputClass="form-control" containerClassName="custom-container"
        multiple
        value={values}
        format="DD/MM/YYYY"
        name={inputName}
        id={id}
        minDate={min}
        maxDate={max ? maxTomorrow : moment().endOf("year").format('L')}
        {...properties}
        onClose={(value) => changeAction(values.map((val) => `${val.year}-${val.month.number.toString().padStart(2, '0')}-${val.day}`))}
        onChange={setValues}
        plugins={[
          <DatePanel />
        ]}
      />
    </React.Fragment>
  );
};

export default MultiDatePicker;
