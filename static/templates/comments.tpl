<script src="https://cdn.tailwindcss.com"></script>

{include file='tabs.tpl' activeLayer="{$active_layer}"}

<main class="w-full rounded bg-white shadow p-3">
  <form method="POST" class="p-3" enctype="multipart/form-data">
    <h5 class="text-xl mb-4">Tworzenie nowej uwagi</h5>
    <input type="hidden" name="action_type" value="create_comment" />
    <div class="md:flex md:items-center mb-6">
      <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">Nazwa kolumny</label>
      <input
        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
        required
        name="name"
      />
    </div>
    <div class="md:flex md:items-center mb-6">
      <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">Uwaga</label>
      <textarea
        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
        required
        name="comment"
      ></textarea>
    </div>
    <button class="cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Dodaj</button>
  </form>

  <div>
    {foreach $comments as $comment}
      <div class="bg-gray-100 my-3 rounded p-3 flex flex-col md:flex-row">
        <form class="flex flex-col md:flex-row w-full" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="action_type" value="edit_comment">
          <input type="hidden" name="comment_id" value="{$comment->getId()}"/>
          <div class="basis-1/6 me-3 mt-3 md:mt-0">
            <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" value="{$comment->getName()}" name="name" />
          </div>
          <div class="basis-5/6 me-3 mt-3 md:mt-0">
            <textarea name="comment" class="w-full bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">{$comment->getComment()}</textarea>
          </div>
          <div> 
            <input type="submit" value="Edytuj" class="cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"/>
          </div>
        </form>
        <form method="POST">
          <input type="hidden" name="action_type" value="delete_comment">
          <input type="hidden" name="comment_id" value="{$comment->getId()}">
          <input type="submit" value="Usuń" class="ms-1 cursor-pointer bg-rose-500 hover:bg-rose-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"/>
        </form>
      </div>
    {/foreach}
  </div>
</main>