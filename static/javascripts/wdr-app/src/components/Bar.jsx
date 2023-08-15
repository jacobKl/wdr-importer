import React from 'react'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faChevronLeft } from '@fortawesome/free-solid-svg-icons'

function Bar({step, make, model, category, goBack}) {
  return (
    <div class="bar">
        <div>
            <button onClick={goBack}><FontAwesomeIcon className="icon" icon={faChevronLeft}></FontAwesomeIcon>Cofnij</button>
        </div>
        <div>
            {step >= 2 ? <span>Marka: <b>{make.name}</b></span> : null}
            {step >= 3 ? <span> | Model: <b>{model.name}</b></span> : null}
        </div>
    </div>
  )
}

export default Bar