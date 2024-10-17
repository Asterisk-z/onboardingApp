import moment from "moment";
import React, { useState, useRef, useEffect } from "react";
import DatePicker, { DateObject } from "react-multi-date-picker"
import DatePanel from "react-multi-date-picker/plugins/date_panel"
// import moment from "moment";

const MultiDatePicker = ({ id, nameAttr, changeAction, max = "", properties, reminderType = null }) => {

  const [values, setValues] = useState([])
  const refValues = useRef([])
  const [inputName, setInputName] = useState(nameAttr)

  const today = new Date()
  const tomorrow = new Date(today)
  tomorrow.setDate(tomorrow.getDate() + 1)

  const [min, setMin] = useState(tomorrow)


  const maxTomorrow = new Date(max)
  maxTomorrow.setDate(maxTomorrow.getDate() + 1)

  const refreshPosition = () => refValues.current.refreshPosition()

  useEffect(() => {
    refValues.current.refreshPosition()
    setValues([])
  }, [reminderType])

  return (
    <React.Fragment>
      <DatePicker inputClass="form-control" containerClassName="custom-container"
        multiple
        value={values}
        format="DD/MM/YYYY"
        ref={refValues}
        name={inputName}
        id={id}
        disabled={!['Monthly', 'Weekly'].includes(reminderType)}
        minDate={min}
        maxDate={max ? maxTomorrow : moment().endOf("year").format('L')}
        {...properties}
        onClose={() => {
          return changeAction(values.map((val) => `${val.year}-${val.month.number.toString().padStart(2, '0')}-${val.day}`))
        }}
        // onChange={updateValue}
        onChange={(selectedDates, validateData) => {

          let latestValue = selectedDates[selectedDates.length - 1]
          let date = `${latestValue.year}-${latestValue.month.number.toString().padStart(2, '0')}-${latestValue.day}`
          let acceptedDates = values.map((item) => `${item.year}-${item.month.number.toString().padStart(2, '0')}-${item.day}`)

          if (reminderType == 'Weekly') {
            let week = values.map((item) => item.weekOfYear)
            if (!week.includes(latestValue.weekOfYear)) return setValues(selectedDates)
            if (acceptedDates.includes(date)) return setValues(selectedDates)
            return false
          }

          if (reminderType == 'Monthly') {
            let monthList = values.map((item) => item.monthIndex)
            if (!monthList.includes(latestValue.monthIndex)) return setValues(selectedDates)
            if (acceptedDates.includes(date)) return setValues(selectedDates)
            return false
          }

          return false;
        }}
        plugins={[
          <DatePanel />
        ]}
      />
    </React.Fragment>
  );
};

export default MultiDatePicker;
