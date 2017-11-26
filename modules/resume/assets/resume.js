var moduleResume = {
    initCompetenceListeners: function(){
        $('#resume-update .add-competence-to-resume').off().on('click', function () {
            moduleResume.addCompentenceToResume();
        });
        $('#resume-update .remove-competence-from-resume').each(function() {
            $(this).off().on('click', function (e) {
                moduleResume.removeCompentenceFromResume(e.target);
            });
        });
        $('#resume-update .field-resumecompetence-title input').each(function() {
            $(this).off().on('input', function (e) {
                moduleResume.onResumeCompetenceInput(e.target);
            });
            $(this).on('blur', function (e) {
                moduleResume.closeSuggestionList(e.target);
            });
        });
    },
    addCompentenceToResume: function(){ 
        $('.resume-update .blank-competence-form .resume-competence-item').clone().appendTo( ".resume-competencies" );
        setTimeout(function(){ 
            moduleResume.initCompetenceListeners();
        }, 0);
    },
    removeCompentenceFromResume: function(btn){
        var deleteNodeFound = false;
        var blockToDelete = btn.parentNode;
        var counter = 0, safety = 20;
        while(deleteNodeFound === false && counter < safety){
            if(blockToDelete.getAttribute('class') && blockToDelete.getAttribute('class').search('resume-competence-item') > -1){
                deleteNodeFound = true;
                $(blockToDelete).remove();
            }else{
                blockToDelete = blockToDelete.parentNode;
            }
            counter++;
        }
    },
    compentenceSuggestionUrl: '',
    compentenceSuggestionCache: {},
    compentenceSuggestionMinLen: 0,
    compentenceSuggestionMaxLen: 0,
    compentenceAutoCompliterList: {},
    configureSuggestion: function(url, min, max){
        moduleResume.compentenceSuggestionUrl = url;
        moduleResume.compentenceSuggestionMinLen = min;
        moduleResume.compentenceSuggestionMaxLen = max;
    },
    onResumeCompetenceInput: function(input){
        if(input.value && input.value.length >= moduleResume.compentenceSuggestionMinLen){
            var q = input.value.substring(0, moduleResume.compentenceSuggestionMaxLen);
            if(!moduleResume.compentenceSuggestionCache[q]){
                $.ajax({
                    type: 'GET', 
                    contentType: 'application/json', 
                    url: moduleResume.compentenceSuggestionUrl, 
                    data: {
                        q: q
                    }, 
                    success: function (data) {
                        moduleResume.compentenceSuggestionCache[q] = true;
                        if (data && Array.isArray(data)) {
                            for (var i = 0; i < data.length; i++) {
                                if (!moduleResume.compentenceAutoCompliterList[data[i].title]) {
                                    moduleResume.compentenceAutoCompliterList[data[i].title] = data[i];
                                }
                            }
                        }
                        moduleResume.recognizeSuggestion(input);
                    }});
            }
        }
        moduleResume.recognizeSuggestion(input);
    },
    recognizeSuggestion: function(input){
        if(!$(input).is(':focus')){
            return;
        }
        
        var suggestionList = [];
        if(moduleResume.compentenceAutoCompliterList){
            $.each(moduleResume.compentenceAutoCompliterList, function(key, autoCompliterObj){
                if (input.value 
                        && input.value.length > 1 
                        && autoCompliterObj 
                        && autoCompliterObj.title.search(input.value) > -1 
                        && autoCompliterObj.title !== input.value) {
                    suggestionList.push(autoCompliterObj);
                }
            });
        }
        
        moduleResume.drawSuggestionList(input, suggestionList);
    },
    closeSuggestionList: function(input){
        var ul = $(input.parentNode).find('.update-resume-suggestions');
        if(ul.length > 0){
            ul.remove();
        }
    },
    drawSuggestionList: function(input, suggestionList){
        if(suggestionList.length === 0){
            moduleResume.closeSuggestionList(input);
            return;
        }
        
        var listItems = $(input.parentNode).find('.update-resume-suggestions .items');
        if(listItems.length === 0){
            var listBlock = $(document.createElement('div'));
            listBlock.addClass('update-resume-suggestions');
            listBlock.appendTo($(input.parentNode));
            listItems = $(document.createElement('div'));
            listItems.addClass('items');
            listItems.appendTo(listBlock);
        } else {
            listItems.empty();
        }
        
        for(var i=0;i < suggestionList.length;i++){
            listItem = $(document.createElement('span'));
            listItem.html(suggestionList[i].title);
            listItem.off().on('mousedown', function (e) {
                e.preventDefault();
            }).on('click', {input: input, title: suggestionList[i].title}, function (e) {
                e.data.input.value = e.data.title;
                moduleResume.closeSuggestionList(e.data.input);
            });
            listItem.appendTo(listItems);
        }
    }
}
