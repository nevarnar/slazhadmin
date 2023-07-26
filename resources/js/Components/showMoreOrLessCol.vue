<template>
    <td class="text-left">
        <p class="whitespace-normal text-left pl-4 text-ellipsis">
            {{
                showFullText
                    ? colData
                    : colData.length > 40
                    ? colData.substring(0, 40) + ".."
                    : colData
            }}
            <button
                v-if="colData.length > 40"
                @click="showFullText = showFullText ? false : true"
                class="ml-4 text-gray-400 text"
            >
                See {{ showFullText ? "Less" : "More" }}
            </button>
        </p>
    </td>
</template>

<script>
export default {
    name: "showMoreOrLessCol",
    props: ["colData"],
    data() {
        return {
            showFullText: false,
        };
    },
    methods: {},
};
</script>
