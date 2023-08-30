import { faFacebookMessenger } from "@fortawesome/free-brands-svg-icons";
import { faEnvelope } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import React from "react";
import { additionalMessage } from "../utils/additional-messages-parser";

function Services({ services, category }) {
  const getPrettyName = (key) => {
    const index = category.sheet_columns.findIndex(element => element == key);
    if (index == -1) return key;
    return category.sheet_columns_display_names[index];
  }

  return (
    <div className="step services-wrapper" data-aos="fade-right">
      {services.length ? (
        <table className="table">
          <thead>
            <tr>
              <th>Usługa</th>
              <th>Cena</th>
              <th>Kontakt</th>
              <th>Uwagi</th>
            </tr>
          </thead>
          <tbody>
            {services.map((service) => (
              <tr>
                <td>{getPrettyName(service.column_name)}</td>
                <td>{service.price != 0 ? (service.price != '-' ? service.price : 'W tym modelu niedostępne') : "Brak ceny w bazie, skontaktuj się z nami"}</td>
                <td>
                  {service.price != 0 ? (
                    service.price != '-' ? <a href="/formularz" className="contact">
                    Chcę naprawić
                  </a> : ''
                  ) : (
                    <a class="contact" href="https://m.me/serwis.wlozdoryzu">
                      <FontAwesomeIcon className="icon" icon={faFacebookMessenger} />
                      Kontakt
                    </a>
                  )}
                </td>
                <td>
                  <span className="additional-message"> {additionalMessage(service.column_name)}</span>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      ) : (
        <h5>
          Brak wpisów w bazie na temat tej naprawy,{" "}
          <a target="_blank" href="/formularz">
            skontaktuj się z nami
          </a>{" "}
          bezpośrednio.
        </h5>
      )}
    </div>
  );
}

export default Services;
