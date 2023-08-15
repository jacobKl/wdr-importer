import { faEnvelope } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import React from 'react'
import { parser } from '../utils/service-name-parser'

function Services({services}) {
  return (
    <div className="step" data-aos="fade-right">
        {services.length ? (<table className="table">
            <thead>
                <tr>
                    <th>Usługa</th>
                    <th>Cena</th>
                </tr>
            </thead>
            <tbody>
            {services.map(service => (
                <tr>
                    <td>{parser(service.column_name)}</td>
                    <td>{service.price} <a href="/formularz" className="contact">Kontakt</a></td>
                </tr>
            ))}
            </tbody>
        </table>) : <h5>Brak wpisów w bazie na temat tej naprawy, <a target="_blank" href="/formularz">skontaktuj się z nami</a> bezpośrednio.</h5>}
    </div>
  )
}

export default Services