{extends 'main.tpl'}
{block name=content}
<div class="dropdown">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	{$title}
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
{foreach $menu as $item}
    <li><a href="{$item[1]}">{$item[0]}</a></li>
{/foreach}
  </ul>
</div>
{block name=content1}{/block}
{/block}
