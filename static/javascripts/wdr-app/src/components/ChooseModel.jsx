import React from 'react'

function ChooseModel({models, handleModelChange}) {
  return (
    <div className="step" data-aos="fade-right">
        <h3>Wybierz model telefonu</h3>
        {models.length ? (
        <>
            <select onInput={(e) => handleModelChange(e)} className="select">
            <option>Wybierz model</option>
            {models.map((model) => (
                <option value={model.id}>{model.name}</option>
            ))}
            </select>
        </>
        ) : null}
    </div>
  )
}

export default ChooseModel