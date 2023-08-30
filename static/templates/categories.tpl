<script src="https://cdn.tailwindcss.com"></script>

{include file='tabs.tpl' activeLayer="{$active_layer}"}

<main class="w-full rounded bg-white shadow p-3">
  <form method="POST" class="p-3" enctype="multipart/form-data">
    <h5 class="text-xl mb-4">Tworzenie nowej kategorii</h5>
    <input type="hidden" name="action_type" value="create_category" />
    <div class="md:flex md:items-center mb-6">
      <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">Nazwa kategorii</label>
      <input
        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
        required
        name="name"
      />
    </div>
    <div class="md:flex md:items-center mb-6">
      <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">Nazwy kolumn</label>
      <textarea
        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
        required
        name="sheet_columns_display_names"
      ></textarea>
    </div>
    <div class="md:flex md:items-center mb-6">
      <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">Kolumny</label>
      <textarea
        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
        required
        name="sheet_columns"
      ></textarea>
    </div>
    <div class="md:flex md:items-center mb-6">
      <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">Obrazek kategorii</label>
      <input type="file" name="image" required/>
    </div>
    <p class="text-xs text-gray-500 mb-3">Wpisz tutaj kolumny z arkusza, które mają być w tej kategorii, poszczególne kolumny oddziel średnikiem.</p>
    <button class="cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Dodaj</button>
  </form>

  <div>
    {foreach $categories as $category}
      <div class="bg-gray-100 my-3 rounded p-3 flex flex-col md:flex-row">
        <form class="flex flex-col md:flex-row w-full" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="action_type" value="edit_category">
          <input type="hidden" name="category_id" value="{$category->getId()}"/>
          <div class="me-3">
            <img src="{$category->getImage()}" class="rounded overflow-hidden" style="max-width: 60px; object-fit: cover;" />
          </div>
          <div class="basis-1/6 me-3 mt-3 md:mt-0">
            <input name="name" value="{$category->getName()}" class="w-full w-100 bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
          </div>
          <div class="basis-2/6 me-3 mt-3 md:mt-0">
            <textarea name="sheet_columns_display_names" class="w-full bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">{$category->getSheetColumnsDisplayNames()}</textarea>
          </div>
          <div class="basis-2/6 me-3 mt-3 md:mt-0">
            <textarea name="sheet_columns" class="w-full bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">{$category->getSheetColumns()}</textarea>
          </div>
          <div class="basis-1/6">
            <p class="text-xs text-gray-500">{$category->getImage()}</p>
            <input type="file" name="image" />
          </div>
          <div> 
            <input type="submit" value="Edytuj" class="cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"/>
          </div>
        </form>
        <form method="POST">
          <input type="hidden" name="action_type" value="delete_category">
          <input type="hidden" name="category_id" value="{$category->getId()}">
          <input type="submit" value="Usuń" class="ms-1 cursor-pointer bg-rose-500 hover:bg-rose-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"/>
        </form>
      </div>
    {/foreach}
  </div>
</main>