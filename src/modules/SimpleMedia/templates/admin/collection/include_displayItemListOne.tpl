{* purpose of this template: inclusion template for display of related collections in admin area *}
{if !isset($nolink)}
    {assign var='nolink' value=false}
{/if}
<h4>
{if !$nolink}
    <a href="{modurl modname='SimpleMedia' type='admin' func='display' ot='collection' id=$item.id}" title="{$item.title|replace:"\"":""}">
{/if}
{$item.title}
{if !$nolink}
    </a>
    <a id="collectionItem{$item.id}Display" href="{modurl modname='SimpleMedia' type='admin' func='display' ot='collection' id=$item.id theme='Printer'}" title="{gt text='Open quick view window'}" class="z-hide">
        {icon type='view' size='extrasmall' __alt='Quick view'}
    </a>
{/if}
</h4>
{if !$nolink}
<script type="text/javascript">
/* <![CDATA[ */
    document.observe('dom:loaded', function() {
        simmedInitInlineWindow($('collectionItem{{$item.id}}Display'), '{{$item.title|replace:"'":""}}');
    });
/* ]]> */
</script>
{/if}
