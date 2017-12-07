<template>
    <div class="data-list-container">
        <DataListItem v-for="(item, index) in items" :text="item.text"></DataListItem>

    </div>
</template>

<script type="text/babel">
    import DataListItem from 'DataListItem'

    export default {
        components: { DataListItem },
        data() {
            return {
                items: [] // todo: how to retrieve data from the server?
            }
        }
    }
</script>