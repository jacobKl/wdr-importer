const root = 'https://www.wlozdoryzu.pl/wp-admin/admin-ajax.php';

const requests = {
    getMakes: async () => {
        const response = await fetch(`${root}?action=get_makes`);
        const json = await response.json();

        return json;
    },
    getModels: async (makeId) => {
        const response = await fetch(`${root}?action=get_models&make_id=${makeId}`);
        const json = await response.json();

        return json;
    },
    getCategories: async (category) => {
        const response = await fetch(`${root}?action=get_categories`);
        const json = await response.json();

        return json;
    },
    getServices: async (make, model, category) => {
        const response = await fetch(`${root}?action=get_services&make_id=${make}&model_id=${model}&category_id=${category}`);
        const json = await response.json();

        return json;
    },
    getComments: async () => {
        const response = await fetch(`${root}?action=get_comments`);
        const json = await response.json();

        return json;
    }
}

export default requests;