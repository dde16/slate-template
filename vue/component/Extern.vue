<template>
    <div ref="extern" style="text-align: left;"></div>
</template>

<script>
import axios from "axios";

/**
 * Used as a method to call backend views,
 * without sending the rest of head, body html etc
 * with it.
 */
export default {
    props: {
        href: {
            type: String,
            required: true
        },
    },
    async mounted() {
        let response;
        try {
            response = await axios.get(this.href, {
                headers: {
                    "Standalone": "1"
                },
                transformResponse: []
            });
        }
        catch(error) {
            response = error.response;
        }
        finally {
            console.log(response);
            if(response?.data != null) {
                this.$refs["extern"].innerHTML = response.data;
            }
        }
        

        
    }
}
</script>