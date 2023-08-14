import { render } from "preact";
import { useEffect, useState } from "preact/hooks";
import "./index.css";
import requests from "./utils/api";

export function App() {
  const [makes, setMakes] = useState([]);
  const [make, setMake] = useState();

  const [models, setModels] = useState([]);
  const [model, setModel] = useState();

  const [categories, setCategories] = useState([]);

  const [prices, setPrices] = useState([]);

  useEffect(() => {
    const getMakes = async () => {
      const response = await requests.getMakes();
      setMakes(response);
    };

    getMakes();

    const getCategories = async () => {
      const response = await requests.getCategories();
      setCategories(response);
    };

    getCategories();
  }, []);

  const handleMakeChange = async (event) => {
    const id = event.target.value;
    const response = await requests.getModels(id);
    setMake(id);
    setModels(response);
  };

  const handleModelChange = async (event) => {
    const id = event.target.value;
    setModel(id);
  };

  const handleCategoryChange = async (category) => {
    const { id } = category;
    const prices = await requests.getServices(make, model, id);
    setPrices(prices);
  };

  return (
    <div className="w-3/4 mx-auto my-3">
      <h3 className="text-xl text-gray-400 mb-3">Wybierz markę i model</h3>
      <div className="flex gap-2">
        <div className="basis-full">
          <select onInput={(e) => handleMakeChange(e)} className="w-full bg-gray-100 p-3 rounded shadow appearance-none">
            <option>Wybierz markę</option>
            {makes.length ? makes.map((make) => <option value={make.id}>{make.name}</option>) : null}
          </select>
        </div>

        {models.length ? (
          <div className="basis-full">
            <select onInput={(e) => handleModelChange(e)} className="w-full bg-gray-100 p-3 rounded shadow appearance-none">
              <option>Wybierz model</option>
              {models.map((model) => (
                <option value={model.id}>{model.name}</option>
              ))}
            </select>
          </div>
        ) : null}
      </div>

      {make && model ? (
        <div className="flex flex-row gap-2 mt-6">
          {categories.map((category) => (
            <div key={category.id} onClick={() => handleCategoryChange(category)} className="basis-1/4 flex-col flex items-center rounded shadow cursor-pointer overflow-hidden">
              <img src={category.image} style="max-height: 300px; height: 100%; object-fit: cover; width: 100%;"/>
              <h3 className="bg-gray-100 p-3 w-full text-center">{category.name}</h3>
            </div>
          ))}
        </div>
      ) : null}

      {prices.length ? (
        <div class="w-full overflow-x-auto mt-6">
          <table class="w-full table-auto border-collapse">
            <thead>
              <tr>
                <th class="px-4 py-2 text-left bg-gray-100 border">Usługa</th>
                <th class="px-4 py-2 text-left bg-gray-100 border">Cena</th>
              </tr>
            </thead>
            <tbody>
				{prices.map(price => (
					<tr>
						<td class="px-4 py-2 border">{price.column_name}</td>
						<td class="px-4 py-2 border">{price.price}</td>
					</tr>
				))}
			</tbody>
          </table>
        </div>
      ) : null}
    </div>
  );
}

render(<App />, document.getElementById("app"));
