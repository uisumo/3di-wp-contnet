window.globalProvideData('slide', '{"title":"           strategies are designed to help COACHES grow in the third dimension.","trackViews":true,"showMenuResultIcon":false,"viewGroupId":"","historyGroupId":"","videoZoom":"","scrolling":false,"transition":"tween","slideLock":false,"navIndex":-1,"globalAudioId":"","thumbnailid":"","presenterRef":{"id":"none"},"showAnimationId":"6HX5irk0SgK","lmsId":"Slide7","width":1000,"height":562,"resume":true,"background":{"type":"swf","imagedata":{"assetId":16,"url":"","type":"normal","width":0,"height":0,"mobiledx":0,"mobiledy":0}},"id":"5WWcjCxWmBx","actionGroups":{"ActGrpOnSubmitButtonClick":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"or","statements":[{"kind":"compare","operator":"eq","valuea":"6AIGjwIK9qu.68UKUmLTdJw.64tuQMH73G5.#_checked","typea":"var","valueb":true,"typeb":"boolean"},{"kind":"compare","operator":"eq","valuea":"6AIGjwIK9qu.68UKUmLTdJw.6018uq7CjoQ.#_checked","typea":"var","valueb":true,"typeb":"boolean"}]}},"thenActions":[{"kind":"eval_interaction","id":"_this.6U4joLMBrig"}],"elseActions":[{"kind":"gotoplay","window":"MessageWnd","wndtype":"normal","objRef":{"type":"string","value":"_player.MsgScene_60ja16FAc0B.InvalidPromptSlide"}}]},{"kind":"exe_actiongroup","id":"_this.NavigationRestrictionNextSlide_5WWcjCxWmBx"}]},"ReviewInt_68UKUmLTdJw":{"kind":"actiongroup","actions":[{"kind":"set_enabled","objRef":{"type":"string","value":"6AIGjwIK9qu.68UKUmLTdJw.64tuQMH73G5"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"6AIGjwIK9qu.68UKUmLTdJw.6018uq7CjoQ"},"enabled":{"type":"boolean","value":false}},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"6U4joLMBrig.$Status","typea":"property","valueb":"correct","typeb":"string"}},"thenActions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"68UKUmLTdJw_CorrectReview"}}],"elseActions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"68UKUmLTdJw_IncorrectReview"}}]},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#CurrentQuiz_68UKUmLTdJw","typea":"var","valueb":"6HyXgqrh1xK","typeb":"string"}},"thenActions":[{"kind":"exe_actiongroup","id":"SetLayout_pxabnsnfns01001010101"},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.6HyXgqrh1xK.$Passed","typea":"property","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewIntCorrectIncorrect_68UKUmLTdJw"}]},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.6HyXgqrh1xK.$Passed","typea":"property","valueb":false,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewIntCorrectIncorrect_68UKUmLTdJw"}]}]}]},"ReviewIntCorrectIncorrect_68UKUmLTdJw":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"6AIGjwIK9qu.68UKUmLTdJw.64tuQMH73G5.$OnStage","typea":"property","valueb":false,"typeb":"boolean"}},"thenActions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6AIGjwIK9qu.68UKUmLTdJw.64tuQMH73G5"}}]},{"kind":"adjustvar","variable":"6AIGjwIK9qu.68UKUmLTdJw.64tuQMH73G5._hover","operator":"set","value":{"type":"boolean","value":false}},{"kind":"adjustvar","variable":"6AIGjwIK9qu.68UKUmLTdJw.64tuQMH73G5._down","operator":"set","value":{"type":"boolean","value":false}},{"kind":"adjustvar","variable":"6AIGjwIK9qu.68UKUmLTdJw.64tuQMH73G5._disabled","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"6AIGjwIK9qu.68UKUmLTdJw.64tuQMH73G5.ActGrpSetReviewState"},{"kind":"set_enabled","objRef":{"type":"string","value":"6AIGjwIK9qu.68UKUmLTdJw.64tuQMH73G5"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"6AIGjwIK9qu.68UKUmLTdJw.6018uq7CjoQ"},"enabled":{"type":"boolean","value":false}}]},"AnsweredInt_68UKUmLTdJw":{"kind":"actiongroup","actions":[{"kind":"exe_actiongroup","id":"DisableChoices_68UKUmLTdJw"},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"pxabnsnfns01001010101"}],"elseActions":[{"kind":"set_window_control_layout","name":"pxabnsnfns01001010101"}]}]},"DisableChoices_68UKUmLTdJw":{"kind":"actiongroup","actions":[{"kind":"exe_actiongroup","id":"6AIGjwIK9qu.68UKUmLTdJw.64tuQMH73G5.ActGrpSetDisabledState"},{"kind":"exe_actiongroup","id":"6AIGjwIK9qu.68UKUmLTdJw.6018uq7CjoQ.ActGrpSetDisabledState"}]},"68UKUmLTdJw_CheckAnswered":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"or","statements":[{"kind":"compare","operator":"eq","valuea":"6U4joLMBrig.$Status","typea":"property","valueb":"correct","typeb":"string"},{"kind":"compare","operator":"eq","valuea":"_player.6HyXgqrh1xK.$QuizComplete","typea":"property","valueb":true,"typeb":"boolean"}]}},"thenActions":[{"kind":"exe_actiongroup","id":"AnsweredInt_68UKUmLTdJw"}],"elseActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"6U4joLMBrig.$Status","typea":"property","valueb":"incorrect","typeb":"string"}},"thenActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"gte","valuea":"6U4joLMBrig.$AttemptCount","typea":"property","valueb":1,"typeb":"number"}},"thenActions":[{"kind":"exe_actiongroup","id":"AnsweredInt_68UKUmLTdJw"}]}]}]}]},"SetLayout_pxabnsnfns01001010101":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"pxabnsnfns01001010101"}],"elseActions":[{"kind":"set_window_control_layout","name":"pxabnsnfns01001010101"}]}]},"NavigationRestrictionNextSlide_5WWcjCxWmBx":{"kind":"actiongroup","actions":[{"kind":"gotoplay","window":"_current","wndtype":"normal","objRef":{"type":"string","value":"_parent.6BnVisfilOg"}}]},"NavigationRestrictionPreviousSlide_5WWcjCxWmBx":{"kind":"actiongroup","actions":[{"kind":"history_prev"}]}},"events":[{"kind":"onbeforeslidein","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"npnxnanbsnfns01001010101"}],"elseActions":[{"kind":"set_window_control_layout","name":"npnxnanbsnfns01001010101"}]}]},{"kind":"onsubmitslide","actions":[{"kind":"exe_actiongroup","id":"ActGrpOnSubmitButtonClick"}]},{"kind":"ontransitionin","actions":[{"kind":"if_action","condition":{"statement":{"kind":"and","statements":[{"kind":"compare","operator":"eq","valuea":"_player.#TimelineCompleted_5WWcjCxWmBx","typea":"var","valueb":false,"typeb":"boolean"},{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_68UKUmLTdJw","typea":"var","valueb":false,"typeb":"boolean"}]}},"thenActions":[{"kind":"enable_frame_control","name":"next","enable":false},{"kind":"enable_frame_control","name":"swiperight","enable":false}]},{"kind":"adjustvar","variable":"_player.LastSlideViewed_60ja16FAc0B","operator":"set","value":{"type":"string","value":"_player."}},{"kind":"adjustvar","variable":"_player.LastSlideViewed_60ja16FAc0B","operator":"add","value":{"type":"property","value":"$AbsoluteId"}},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_68UKUmLTdJw","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewInt_68UKUmLTdJw"}],"elseActions":[{"kind":"exe_actiongroup","id":"68UKUmLTdJw_CheckAnswered"}]}]},{"kind":"onnextslide","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_68UKUmLTdJw","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#CurrentQuiz_68UKUmLTdJw","typea":"var","valueb":"6HyXgqrh1xK","typeb":"string"}},"thenActions":[{"kind":"nextviewedslide","quizRef":{"type":"string","value":"_player.6HyXgqrh1xK"},"completed_slide_ref":{"type":"string","value":"_player.5mbKk5DfB96.5nnSyv28G8M"}}],"elseActions":[]}],"elseActions":[{"kind":"exe_actiongroup","id":"NavigationRestrictionNextSlide_5WWcjCxWmBx"}]}]},{"kind":"onprevslide","actions":[{"kind":"exe_actiongroup","id":"NavigationRestrictionPreviousSlide_5WWcjCxWmBx"}]},{"kind":"ontimelinecomplete","actions":[{"kind":"adjustvar","variable":"_player.TimelineCompleted_5WWcjCxWmBx","operator":"set","value":{"type":"boolean","value":true}},{"kind":"enable_frame_control","name":"next","enable":true},{"kind":"enable_frame_control","name":"swiperight","enable":true}]}],"slideLayers":[{"enableSeek":true,"enableReplay":true,"timeline":{"duration":5000,"events":[{"kind":"ontimelinetick","time":0,"actions":[{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"5Ul6iAVr8lT"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5Ul6iAVr8lT.5nn8zYE4spH"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5Ul6iAVr8lT.6QXk6HuywMe"}},{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"6ootJf5BzON"}}]},{"kind":"ontimelinetick","time":750,"actions":[{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"6AIGjwIK9qu"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6AIGjwIK9qu.68UKUmLTdJw"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6AIGjwIK9qu.68UKUmLTdJw.64tuQMH73G5"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6AIGjwIK9qu.68UKUmLTdJw.6018uq7CjoQ"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6AIGjwIK9qu.6p7Oi0OJISz"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6AIGjwIK9qu.6CBopmlR8pE"}}]}]},"objects":[{"kind":"objgroup","objects":[{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":17,"id":"01","url":"story_content/5xGIGMGu8bz_80_DX1998_DY1998.swf","type":"normal","altText":"objectives.png","width":1920,"height":301,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":8,"yPos":8,"tabIndex":1,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":499.5,"rotateYPos":51.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":1,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":999,"bottom":103,"altText":"objectives.png","pngfb":false,"pr":{"l":"Lib","i":44}},"html5data":{"xPos":0,"yPos":0,"width":999,"height":103,"strokewidth":0}},"width":999,"height":103,"resume":true,"useHandCursor":true,"id":"5nn8zYE4spH"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"6QXk6HuywMe_-302170048","id":"01","linkId":"txt__default_6QXk6HuywMe","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":938,"bottom":94,"pngfb":false,"pr":{"l":"Lib","i":46}}}],"shapemaskId":"","xPos":32,"yPos":8,"tabIndex":2,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":476.5,"rotateYPos":50,"scaleX":100,"scaleY":100,"alpha":100,"depth":2,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":953,"bottom":100,"altText":"“If your outgo exceeds your income, then your upkeep will be your downfall.” – Bill Earle","pngfb":false,"pr":{"l":"Lib","i":45}},"html5data":{"xPos":-1,"yPos":-1,"width":954,"height":101,"strokewidth":0}},"width":953,"height":100,"resume":true,"useHandCursor":true,"id":"6QXk6HuywMe"}],"accType":"text","altText":"Group\\r\\n 2","shapemaskId":"","xPos":-8,"yPos":-8,"tabIndex":0,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":507.5,"rotateYPos":59.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":1,"scrolling":true,"shuffleLock":false,"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":750,"easing":"linear","easingdir":"easein"}},{"kind":"tween","time":0,"duration":750,"position":{"relativerotation":false,"relativestartpoint":false,"path":[{"kind":"segment","type":"line","anchora":{"x":"$RawXPos","y":"$RawYPos","dx":"0","dy":"-116"},"anchorb":{"x":"$RawXPos","y":"$RawYPos","dx":"0","dy":"0"}}],"duration":750,"easing":"cubic","easingdir":"easeout"}}]}],"width":1015,"height":119,"resume":true,"useHandCursor":true,"id":"5Ul6iAVr8lT"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","shapemaskId":"","xPos":-167,"yPos":136,"tabIndex":3,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":328,"rotateYPos":177.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":2,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":656,"bottom":356,"altText":"Parallelogram 1","pngfb":false,"pr":{"l":"Lib","i":47}},"html5data":{"xPos":-1,"yPos":-1,"width":657,"height":356,"strokewidth":0}},"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":750,"easing":"linear","easingdir":"easein"}},{"kind":"tween","time":0,"duration":750,"position":{"relativerotation":false,"relativestartpoint":false,"path":[{"kind":"segment","type":"line","anchora":{"x":"$RawXPos","y":"$RawYPos","dx":"-494","dy":"0"},"anchorb":{"x":"$RawXPos","y":"$RawYPos","dx":"0","dy":"0"}}],"duration":750,"easing":"cubic","easingdir":"easeout"}}]}],"width":656,"height":355,"resume":true,"useHandCursor":true,"id":"6ootJf5BzON"},{"kind":"objgroup","objects":[{"kind":"scrollarea","contentwidth":241,"contentheight":110,"objects":[{"kind":"shufflegroup","objects":[{"kind":"vectorshape","rotation":0,"accType":"radio","cliptobounds":false,"defaultAction":"onrelease","textLib":[{"kind":"textdata","uniqueId":"6mRsa9rMOsD_-346848452","id":"01","linkId":"txt__default_64tuQMH73G5","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":94,"bottom":42,"pngfb":false,"pr":{"l":"Lib","i":55}}}],"shapemaskId":"","xPos":24,"yPos":0,"tabIndex":10,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":108.5,"rotateYPos":27.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":1,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“To”","pngfb":false,"pr":{"l":"Lib","i":49}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":0}},"states":[{"kind":"state","name":"_default_Disabled","data":{"hotlinkId":"","accState":1,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“To”","pngfb":false,"pr":{"l":"Lib","i":49}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Review","data":{"hotlinkId":"","accState":0,"vectorData":{"left":-9,"top":-1,"right":217,"bottom":55,"altText":"“To”","pngfb":false,"pr":{"l":"Lib","i":50}},"html5data":{"xPos":-9,"yPos":-1,"width":226,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Down","data":{"hotlinkId":"","accState":8,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“To”","pngfb":false,"pr":{"l":"Lib","i":49}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Selected","data":{"hotlinkId":"","accState":16,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“To”","pngfb":false,"pr":{"l":"Lib","i":51}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Selected_Disabled","data":{"hotlinkId":"","accState":17,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“To”","pngfb":false,"pr":{"l":"Lib","i":51}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Selected_Review","data":{"hotlinkId":"","accState":16,"vectorData":{"left":-9,"top":-1,"right":217,"bottom":55,"altText":"“To”","pngfb":false,"pr":{"l":"Lib","i":52}},"html5data":{"xPos":-9,"yPos":-1,"width":226,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Down_Selected","data":{"hotlinkId":"","accState":24,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“To”","pngfb":false,"pr":{"l":"Lib","i":51}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Hover","data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“To”","pngfb":false,"pr":{"l":"Lib","i":53}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Hover_Disabled","data":{"hotlinkId":"","accState":1,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“To”","pngfb":false,"pr":{"l":"Lib","i":53}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Hover_Down","data":{"hotlinkId":"","accState":8,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“To”","pngfb":false,"pr":{"l":"Lib","i":53}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Hover_Selected","data":{"hotlinkId":"","accState":16,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“To”","pngfb":false,"pr":{"l":"Lib","i":54}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Hover_Selected_Disabled","data":{"hotlinkId":"","accState":17,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“To”","pngfb":false,"pr":{"l":"Lib","i":54}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Hover_Down_Selected","data":{"hotlinkId":"","accState":24,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“To”","pngfb":false,"pr":{"l":"Lib","i":54}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}}],"width":217,"height":55,"resume":true,"useHandCursor":true,"id":"64tuQMH73G5","variables":[{"kind":"variable","name":"_hover","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_down","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_disabled","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_checked","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_review","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_state","type":"string","value":"_default","resume":true},{"kind":"variable","name":"_stateName","type":"string","value":"","resume":true},{"kind":"variable","name":"_tempStateName","type":"string","value":"","resume":false}],"actionGroups":{"ActGrpSetCheckedState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_checked","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}},{"kind":"exe_actiongroup","id":"ActGrpUnchecked"}]},"ActGrpUnchecked":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_parent.6018uq7CjoQ.#_checked","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"adjustvar","variable":"_parent.6018uq7CjoQ._checked","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_parent.6018uq7CjoQ"}}]}]},"ActGrpSetHoverState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_hover","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpClearHoverState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_hover","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpSetDisabledState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_disabled","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpSetDownState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_down","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpSetReviewState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_review","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpClearStateVars":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_hover","operator":"set","value":{"type":"boolean","value":false}},{"kind":"adjustvar","variable":"_down","operator":"set","value":{"type":"boolean","value":false}},{"kind":"adjustvar","variable":"_disabled","operator":"set","value":{"type":"boolean","value":false}},{"kind":"adjustvar","variable":"_checked","operator":"set","value":{"type":"boolean","value":false}},{"kind":"adjustvar","variable":"_review","operator":"set","value":{"type":"boolean","value":false}}]}},"events":[{"kind":"ontransitionin","actions":[{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onrollover","actions":[{"kind":"exe_actiongroup","id":"ActGrpSetHoverState","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onrollout","actions":[{"kind":"exe_actiongroup","id":"ActGrpClearHoverState","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onpress","actions":[{"kind":"exe_actiongroup","id":"ActGrpSetDownState","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onrelease","actions":[{"kind":"exe_actiongroup","id":"ActGrpUnchecked"},{"kind":"adjustvar","variable":"_checked","operator":"set","value":{"type":"boolean","value":true}},{"kind":"adjustvar","variable":"_down","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onreleaseoutside","actions":[{"kind":"adjustvar","variable":"_down","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]}]},{"kind":"vectorshape","rotation":0,"accType":"radio","cliptobounds":false,"defaultAction":"onrelease","textLib":[{"kind":"textdata","uniqueId":"5zge6EDwaWf_-654610683","id":"01","linkId":"txt__default_6018uq7CjoQ","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":156,"bottom":42,"pngfb":false,"pr":{"l":"Lib","i":58}}}],"shapemaskId":"","xPos":24,"yPos":55,"tabIndex":11,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":108.5,"rotateYPos":27.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":2,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“Through”","pngfb":false,"pr":{"l":"Lib","i":56}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":0}},"states":[{"kind":"state","name":"_default_Disabled","data":{"hotlinkId":"","accState":1,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“Through”","pngfb":false,"pr":{"l":"Lib","i":56}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Down","data":{"hotlinkId":"","accState":8,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“Through”","pngfb":false,"pr":{"l":"Lib","i":56}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Selected","data":{"hotlinkId":"","accState":16,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“Through”","pngfb":false,"pr":{"l":"Lib","i":51}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Selected_Disabled","data":{"hotlinkId":"","accState":17,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“Through”","pngfb":false,"pr":{"l":"Lib","i":51}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Down_Selected","data":{"hotlinkId":"","accState":24,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“Through”","pngfb":false,"pr":{"l":"Lib","i":51}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Hover","data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“Through”","pngfb":false,"pr":{"l":"Lib","i":57}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Hover_Disabled","data":{"hotlinkId":"","accState":1,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“Through”","pngfb":false,"pr":{"l":"Lib","i":57}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Hover_Down","data":{"hotlinkId":"","accState":8,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“Through”","pngfb":false,"pr":{"l":"Lib","i":57}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Hover_Selected","data":{"hotlinkId":"","accState":16,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“Through”","pngfb":false,"pr":{"l":"Lib","i":54}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Hover_Selected_Disabled","data":{"hotlinkId":"","accState":17,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“Through”","pngfb":false,"pr":{"l":"Lib","i":54}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}},{"kind":"state","name":"_default_Hover_Down_Selected","data":{"hotlinkId":"","accState":24,"vectorData":{"left":-1,"top":-1,"right":217,"bottom":55,"altText":"“Through”","pngfb":false,"pr":{"l":"Lib","i":54}},"html5data":{"xPos":-1,"yPos":-1,"width":218,"height":56,"strokewidth":3}}}],"width":217,"height":55,"resume":true,"useHandCursor":true,"id":"6018uq7CjoQ","variables":[{"kind":"variable","name":"_hover","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_down","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_disabled","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_checked","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_state","type":"string","value":"_default","resume":true},{"kind":"variable","name":"_stateName","type":"string","value":"","resume":true},{"kind":"variable","name":"_tempStateName","type":"string","value":"","resume":false}],"actionGroups":{"ActGrpSetCheckedState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_checked","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}},{"kind":"exe_actiongroup","id":"ActGrpUnchecked"}]},"ActGrpUnchecked":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_parent.64tuQMH73G5.#_checked","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"adjustvar","variable":"_parent.64tuQMH73G5._checked","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_parent.64tuQMH73G5"}}]}]},"ActGrpSetHoverState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_hover","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpClearHoverState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_hover","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpSetDisabledState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_disabled","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpSetDownState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_down","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpClearStateVars":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_hover","operator":"set","value":{"type":"boolean","value":false}},{"kind":"adjustvar","variable":"_down","operator":"set","value":{"type":"boolean","value":false}},{"kind":"adjustvar","variable":"_disabled","operator":"set","value":{"type":"boolean","value":false}},{"kind":"adjustvar","variable":"_checked","operator":"set","value":{"type":"boolean","value":false}}]}},"events":[{"kind":"ontransitionin","actions":[{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onrollover","actions":[{"kind":"exe_actiongroup","id":"ActGrpSetHoverState","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onrollout","actions":[{"kind":"exe_actiongroup","id":"ActGrpClearHoverState","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onpress","actions":[{"kind":"exe_actiongroup","id":"ActGrpSetDownState","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onrelease","actions":[{"kind":"exe_actiongroup","id":"ActGrpUnchecked"},{"kind":"adjustvar","variable":"_checked","operator":"set","value":{"type":"boolean","value":true}},{"kind":"adjustvar","variable":"_down","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onreleaseoutside","actions":[{"kind":"adjustvar","variable":"_down","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]}]}],"shuffle":false,"shapemaskId":"","xPos":0,"yPos":0,"tabIndex":-1,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":0,"rotateYPos":0,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":1,"scrolling":true,"shuffleLock":false,"width":0,"height":0,"resume":false,"useHandCursor":true,"id":""}],"shapemaskId":"","xPos":-16,"yPos":143,"tabIndex":7,"tabEnabled":false,"xOffset":0,"yOffset":0,"rotateXPos":108.5,"rotateYPos":68.5,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":1,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"html5data":{"url":"","xPos":33,"yPos":313,"width":216,"height":137,"strokewidth":0}},"width":240,"height":137,"resume":true,"useHandCursor":true,"background":{"type":"vector","vectorData":{"left":0,"top":0,"right":241,"bottom":138,"altText":"Multiple Choice","pngfb":false,"pr":{"l":"Lib","i":48}}},"id":"68UKUmLTdJw"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"6p7Oi0OJISz_59256683","id":"01","linkId":"txt__default_6p7Oi0OJISz","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":393,"bottom":108,"pngfb":false,"pr":{"l":"Lib","i":60}}}],"shapemaskId":"","xPos":8,"yPos":8,"tabIndex":5,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":211,"rotateYPos":57,"scaleX":100,"scaleY":100,"alpha":100,"depth":2,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":422,"bottom":114,"altText":"           strategies are designed to help COACHES grow in the third dimension.","pngfb":false,"pr":{"l":"Lib","i":59}},"html5data":{"xPos":-1,"yPos":-1,"width":423,"height":115,"strokewidth":0}},"width":422,"height":114,"resume":true,"useHandCursor":true,"id":"6p7Oi0OJISz"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","shapemaskId":"","xPos":24,"yPos":41,"tabIndex":6,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":41.5,"rotateYPos":0,"scaleX":100,"scaleY":100,"alpha":100,"depth":3,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":-4,"top":-4,"right":88,"bottom":4,"altText":"Line 1","pngfb":false,"pr":{"l":"Lib","i":61}},"html5data":{"xPos":-1,"yPos":-1,"width":84,"height":1,"strokewidth":4}},"width":83,"height":0,"resume":true,"useHandCursor":true,"id":"6CBopmlR8pE"}],"accType":"text","altText":"Group\\r\\n 3","shapemaskId":"","xPos":25,"yPos":170,"tabIndex":4,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":219,"rotateYPos":144,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":3,"scrolling":true,"shuffleLock":false,"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":750,"easing":"linear","easingdir":"easein"}}]}],"width":438,"height":288,"resume":true,"useHandCursor":true,"id":"6AIGjwIK9qu"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"68UKUmLTdJw_CorrectReview","id":"01","linkId":"68UKUmLTdJw_CorrectReview","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":540,"bottom":37,"pngfb":false,"pr":{"l":"Lib","i":38}}}],"shapemaskId":"","xPos":0,"yPos":522,"tabIndex":12,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":500,"rotateYPos":20,"scaleX":100,"scaleY":100,"alpha":100,"depth":4,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":1000,"bottom":40,"altText":"Correct","pngfb":false,"pr":{"l":"Lib","i":37}},"html5data":{"xPos":1,"yPos":1,"width":997,"height":37,"strokewidth":2}},"width":1000,"height":40,"resume":false,"useHandCursor":true,"id":"68UKUmLTdJw_CorrectReview","events":[{"kind":"onrelease","actions":[{"kind":"hide","transition":"appear","objRef":{"type":"string","value":"_this"}}]}]},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"68UKUmLTdJw_IncorrectReview","id":"01","linkId":"68UKUmLTdJw_IncorrectReview","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":549,"bottom":37,"pngfb":false,"pr":{"l":"Lib","i":40}}}],"shapemaskId":"","xPos":0,"yPos":522,"tabIndex":13,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":500,"rotateYPos":20,"scaleX":100,"scaleY":100,"alpha":100,"depth":5,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":1000,"bottom":40,"altText":"Incorrect","pngfb":false,"pr":{"l":"Lib","i":39}},"html5data":{"xPos":1,"yPos":1,"width":997,"height":37,"strokewidth":2}},"width":1000,"height":40,"resume":false,"useHandCursor":true,"id":"68UKUmLTdJw_IncorrectReview","events":[{"kind":"onrelease","actions":[{"kind":"hide","transition":"appear","objRef":{"type":"string","value":"_this"}}]}]}],"startTime":-1,"elapsedTimeMode":"normal","animations":[{"kind":"animation","id":"6HX5irk0SgK","duration":500,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":500,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":500,"easing":"linear","easingdir":"easein"}}]}],"useHandCursor":false,"resume":true,"kind":"slidelayer","isBaseLayer":true}]}');