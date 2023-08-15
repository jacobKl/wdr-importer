import React from 'react'

function ChooseMake({makes, handleMakeChange}) {
  return (
    <div className="step" data-aos="fade-right">
        <h3>Wybierz markę telefonu</h3>
        <p>Aby wybrać markę rozwiń pole i wybierz markę, która znajduje się w naszej bazie. Nieobecność danej marki świadczy o nie wykonywaniu usług dla danych telefonów.</p>
    
        <>
            <select onInput={(e) => handleMakeChange(e)} className="select">
                <option>Wybierz markę</option>
                {makes.length ? makes.map((make) => <option value={make.id}>{make.name}</option>) : null}
            </select>
        </>
    </div>
  )
}

export default ChooseMake