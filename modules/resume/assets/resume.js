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
            //todo
            $(this).blur(function (e) {
                setTimeout(function(){
                    moduleResume.closeSuggestionList(e.target);
                }, 200);
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
    compentenceAutoCompliterList: [],
    onResumeCompetenceInput: function(input){
        moduleResume.recognizeSuggestion(input);
    },
    recognizeSuggestion: function(input){
        var suggestionList = [];
        if(moduleResume.compentenceAutoCompliterList){
            for (var i = 0; i < moduleResume.compentenceAutoCompliterList.length; i++) {
                var autoCompliterObj = moduleResume.compentenceAutoCompliterList[i];
                if (input.value 
                        && input.value.length > 1 
                        && autoCompliterObj 
                        && autoCompliterObj.title.search(input.value) > -1 
                        && autoCompliterObj.title !== input.value) {
                    suggestionList.push(autoCompliterObj);
                }
            }
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
        
        var ul = $(input.parentNode).find('.update-resume-suggestions');
        if(ul.length === 0){
            ul = $(document.createElement('ul'));
            ul.addClass('update-resume-suggestions');
            ul.appendTo($(input.parentNode));
        } else {
            ul.empty();
        }
        
        for(var i=0;i < suggestionList.length;i++){
            li = $(document.createElement('li'));
            li.html(suggestionList[i].title);
            li.off().on('click', {input: input, title: suggestionList[i].title}, function (e) {
                e.data.input.value = e.data.title;
                moduleResume.closeSuggestionList(e.data.input);
            });
            li.appendTo(ul);
        }
    }
}
