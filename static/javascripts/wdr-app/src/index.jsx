import Aos from "aos";
import { render } from "preact";
import { useEffect, useState } from "preact/hooks";
import ChooseMake from "./components/ChooseMake";
import "./index.scss";
import "aos/dist/aos.css";
import requests from "./utils/api";
import ChooseModel from "./components/ChooseModel";
import Loader from "./components/Loader";
import Categories from "./components/Categories";
import Services from "./components/Services";
import Bar from "./components/Bar";

export function App() {
  const [makes, setMakes] = useState([]);
  const [make, setMake] = useState({});

  const [models, setModels] = useState([]);
  const [model, setModel] = useState({});

  const [categories, setCategories] = useState([]);
  const [category, setCategory] = useState({})

  const [services, setServices] = useState([]);

  const [step, setStep] = useState(1);

  const [loading, setLoading] = useState(false);

  const goBack = () => {
    setStep(step - 1);
  }

  const renderer = () => {
    switch(step) {
      case 1: 
        return <ChooseMake makes={makes} handleMakeChange={handleMakeChange} />
      case 2: 
        return loading ? <Loader /> : <ChooseModel models={models} handleModelChange={handleModelChange}/>
      case 3: 
        return <Categories categories={categories} handleCategoryChange={handleCategoryChange} />
      case 4: 
        return loading ? <Loader /> : <Services services={services} category={category} />
    }
  }

  useEffect(() => {
    Aos.init({
      once: true
    });

    const getMakes = async () => {
      const response = await requests.getMakes();
      setMakes(response);
    };

    getMakes();

    const getCategories = async () => {
      let response = await requests.getCategories();

      if (response.length) {
        response = response.map(category => ({
          ...category,
          sheet_columns: category.sheet_columns.split(';'),
          sheet_columns_display_names: category.sheet_columns_display_names.split(';'),
        }))
      }
      setCategories(response);
    };

    getCategories();
  }, []);

  const handleMakeChange = async (event) => {
    const id = event.target.value;
    const name = event.nativeEvent.target[event.nativeEvent.target.selectedIndex].text;

    setStep(2);
    setLoading(true);
    const response = await requests.getModels(id);
    setLoading(false);
    setMake({id, name});
    setModels(response);
  };

  const handleModelChange = async (event) => {
    const id = event.target.value;
    const name = event.nativeEvent.target[event.nativeEvent.target.selectedIndex].text;

    setModel({id, name});
    setStep(3);
  };

  const handleCategoryChange = async (category) => {
    const { id } = category;
    setStep(4);
    setLoading(true);
    setCategory(category);
    const services = await requests.getServices(make.id, model.id, id);
    setLoading(false);
    setServices(services);
  };

  return (
    <>
      { step > 1 ? <Bar step={step} goBack={goBack} make={make} model={model}/> : null}
      {renderer()}
      <p>Jeżeli nie widzisz swojego modelu na liście, <a href="https://m.me/serwis.wlozdoryzu">skontaktuj się</a> z nami.</p>
    </>
  );
}

render(<App />, document.getElementById("app"));
