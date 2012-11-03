{* purpose of this template: collections view view in user area *}
{include file='user/header.tpl'}
<div class="simplemedia-collection simplemedia-view">
{gt text='Collection list' assign='templateTitle'}
{pagesetvar name='title' value=$templateTitle}
<div class="z-frontendcontainer">
    <h2>{$templateTitle}</h2>

<p class="sectiondesc">Collections form a nested tree that contain one or more media items. </p>

{assign var='own' value=0}
{if isset($showOwnEntries) && $showOwnEntries eq 1}
    {assign var='own' value=1}
{/if}
{assign var='all' value=0}
{if isset($showAllEntries) && $showAllEntries eq 1}
    {gt text='Back to paginated view' assign='linkTitle'}
    <a href="{modurl modname='SimpleMedia' type='user' func='view' ot='collection'}" title="{$linkTitle}" class="z-icon-es-view">
        {$linkTitle}
    </a>
    {assign var='all' value=1}
{else}
    {gt text='Show all entries' assign='linkTitle'}
    <a href="{modurl modname='SimpleMedia' type='user' func='view' ot='collection' all=1}" title="{$linkTitle}" class="z-icon-es-view">
        {$linkTitle}
    </a>
{/if}
{gt text='Switch to hierarchy view' assign='linkTitle'}
<a href="{modurl modname='SimpleMedia' type='user' func='view' ot='collection' tpl='tree'}" title="{$linkTitle}" class="z-icon-es-view">
    {$linkTitle}
</a>

{include file='user/collection/view_quickNav.tpl'}{* see template file for available options *}

<table class="z-datatable">
    <colgroup>
        <col id="ctitle" />
        <col id="cdescription" />
        <col id="citemactions" />
    </colgroup>
    <thead>
    <tr>
        <th id="htitle" scope="col" class="z-left">
            {sortlink __linktext='Title' sort='title' currentsort=$sort sortdir=$sdir all=$all own=$own catid=$catId searchterm=$searchterm pageSize=$pageSize modname='SimpleMedia' type='user' func='view' ot='collection'}
        </th>
        <th id="hdescription" scope="col" class="z-left">
            {sortlink __linktext='Description' sort='description' currentsort=$sort sortdir=$sdir all=$all own=$own catid=$catId searchterm=$searchterm pageSize=$pageSize modname='SimpleMedia' type='user' func='view' ot='collection'}
        </th>
        <th id="hitemactions" scope="col" class="z-right z-order-unsorted">{gt text='Actions'}</th>
    </tr>
    </thead>
    <tbody>

{foreach item='collection' from=$items}
    <tr class="{cycle values='z-odd, z-even'}">
        <td headers="htitle" class="z-left">
            {$collection.title|notifyfilters:'simplemedia.filterhook.collections'}
        </td>
        <td headers="hdescription" class="z-left">
            {$collection.description}
        </td>
        <td id="itemactions{$collection.id}" headers="hitemactions" class="z-right z-nowrap z-w02">
            {if count($collection._actions) gt 0}
                {foreach item='option' from=$collection._actions}
                    <a href="{$option.url.type|simplemediaActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}"{if $option.icon eq 'preview'} target="_blank"{/if}>{icon type=$option.icon size='extrasmall' alt=$option.linkText|safetext}</a>
                {/foreach}
                {icon id="itemactions`$collection.id`trigger" type='options' size='extrasmall' __alt='Actions' class='z-pointer z-hide'}
                <script type="text/javascript">
                /* <![CDATA[ */
                    document.observe('dom:loaded', function() {
                        simmedInitItemActions('collection', 'view', 'itemactions{{$collection.id}}');
                    });
                /* ]]> */
                </script>
            {/if}
        </td>
    </tr>
{foreachelse}
    <tr class="z-datatableempty">
      <td class="z-left" colspan="3">
    {gt text='No collections found.'}
      </td>
    </tr>
{/foreach}

    </tbody>
</table>

{if !isset($showAllEntries) || $showAllEntries ne 1}
    {pager rowcount=$pager.numitems limit=$pager.itemsperpage display='page'}
{/if}

{notifydisplayhooks eventname='simplemedia.ui_hooks.collections.display_view' urlobject=$currentUrlObject assign='hooks'}
{foreach key='providerArea' item='hook' from=$hooks}
    {$hook}
{/foreach}
</div>
</div>
{include file='user/footer.tpl'}
