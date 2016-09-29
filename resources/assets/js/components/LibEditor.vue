<template>
    <div class="col-md-2">
        <div class="part-of-speech-card">Noun</div>
        <div class="part-of-speech-card">Verb</div>
        <div class="part-of-speech-card">Adjective</div>
        <div class="part-of-speech-card">Adverb</div>
    </div>

    <div class="col-md-2">
        <div class="part-of-speech-card">Plural Noun</div>
        <div class="part-of-speech-card">Verb (ing)</div>
        <div class="part-of-speech-card">Number</div>
        <div class="part-of-speech-card">Person</div>
    </div>

    <div class="col-md-8">
        <div class="form-group">
            <label for="title">Title</label>
            <input id="title" name="title" class="form-control" v-model="title">
        </div>

        <div class="form-group">
            <label for="lib-body">Body</label>
            <div contenteditable="true" id="lib-body" class="form-control"></div>
        </div>

        <div class="form-group">
            <button class="btn btn-default" @click="save">Save Lib</button>
        </div>
    </div>
</template>

<style>
    .part-of-speech-card{
        height: 50px;
        width: 66%;
        padding: 12px;
        margin-top: 10px;
        text-align: center;
        border: 1px solid;
        z-index: 10;
        cursor: pointer;
    }

    #lib-body{
        overflow: scroll;
        height: 500px;
        padding: 15px;
        line-height: 40px;
    }
</style>

<script>
    export default{
        data(){
            return{
                title: '',
            }
        },

        methods:{
            save() {
                var div = $('#lib-body')[0];

                var children = div.children;
                var body = div.innerHTML;

                var inputs = [];

                for (var i = 0; i < children.length; i++) {
                    var child = children[i];

                    inputs[i] = {
                        'id': child.id,
                        'speech': child.placeholder,
                        'value': child.value,
                    };
                }

                this.postLib({
                    'inputs': inputs,
                    'body': body,
                    'title': this.title,
                });
            },

            postLib(postData) {
                this.$http.post("/libs", postData)
                    .then(
                        function (res) {
                            window.location.href = res.body.url;
                        },
                        function (err) {
                            console.warn(err);
                        }
                    );
            }
        },

        ready() {

        },
    }

    $(document).ready( function() {
        // used to keep track of which input to focus on
        var inputCounter = 0;

        // click to insert

        $('.part-of-speech-card').click(function() {
            var partOfSpeech = $(this).text().toLowerCase();

            insertInput(partOfSpeech)

            return false;
        });


        // Draggable and droppable not registering as functions
        // Should come from jquery ui

//          .draggable({helper: 'clone'});

        // drag and drop to insert
//        $("#lib-body").droppable({
//
//            accept: ".part-of-speech-card",
//
//            drop: function(ev, ui) {
//                var card = ui.draggable;
//                var partOfSpeech = $(card)[0].textContent.toLowerCase();
//
//                insertInput(partOfSpeech);
//            }
//        });


        // renders input to body
        function insertInput(partOfSpeech)
        {
            var input = '<input ' +
                    'id="input-' + inputCounter + '"' +
                    'placeholder="' + partOfSpeech + '">';

            $("#lib-body").insertAtCaret(input);

            $("#input-" + inputCounter).focus();
            inputCounter++;
        }


    });



    // have not adjusted to work on IE or Mozilla

    // inserts text at carat location
    $.fn.insertAtCaret = function (input) {
        return this.each(function(){
            //IE support
            if (document.selection) {
                this.focus();
                sel = document.selection.createRange();
                sel.innerHTML = input;
                this.focus();
            }
            //MOZILLA / NETSCAPE support
            else if (this.selectionStart || this.selectionStart == '0') {
                var startPos = this.selectionStart;
                var endPos = this.selectionEnd;
                var scrollTop = this.scrollTop;
                this.value = this.value.substring(0, startPos)+ input+ this.value.substring(endPos,this.value.length);
                this.focus();
                this.selectionStart = startPos + input.length;
                this.selectionEnd = startPos + input.length;
                this.scrollTop = scrollTop;
            } else {
                $('#' + this.id).append(input);
                this.focus();
            }
        });
    };

</script>
