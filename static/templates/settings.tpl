<script src="https://cdn.tailwindcss.com"></script>

{include file='tabs.tpl' activeLayer="{$active_layer}"}

<main class="w-full rounded bg-white shadow p-3">
  <h3 class="px-3 text-4xl font-extrabold mb-4">Ustawienia importera</h3>
  <form class="p-3" method="POST" action="" enctype="multipart/form-data">
    <input type="hidden" name="action_type" value="update_settings">
    <div class="md:flex md:items-center mb-6">
      <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">Arkusz</label>
      <input
        required
        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
        name="sheet"
        value="{$sheet}"
        />
    </div>
    <div class="md:flex md:items-center mb-6">
        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">Klucz API</label>
        <div>
          {if $file_exists}
            <p>Plik konfiguracyjny dodany.</p>
          {/if}
          <input
            name="conf_file"
            class="block"
            type="file"
          />
        </div>
      </div>
      <div class="md:flex md:items-center mb-6">
        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">Pora pobierania</label>
        <input
          required
          class="bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
          name="cron"
          value="{$cron}"
        />
      </div>
      <input type="submit" value="Zapisz" class="cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" />
  </form>
</main>
