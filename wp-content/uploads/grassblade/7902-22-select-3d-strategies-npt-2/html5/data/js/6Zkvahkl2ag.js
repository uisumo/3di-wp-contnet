window.globalProvideData('slide', '{"title":"Pick One","trackViews":true,"showMenuResultIcon":false,"viewGroupId":"","historyGroupId":"","videoZoom":"","scrolling":false,"transition":"tween","slideLock":false,"navIndex":-1,"globalAudioId":"","thumbnailid":"","presenterRef":{"id":"none"},"showAnimationId":"5xFOgIZLpu7","lmsId":"Slide3","width":1000,"height":562,"resume":true,"background":{"type":"swf","imagedata":{"assetId":10,"url":"","type":"normal","width":0,"height":0,"mobiledx":0,"mobiledy":0}},"id":"6Zkvahkl2ag","actionGroups":{"ActGrpOnSubmitButtonClick":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"or","statements":[{"kind":"compare","operator":"eq","valuea":"6Uds3r1HeGv.#_checked","typea":"var","valueb":true,"typeb":"boolean"},{"kind":"compare","operator":"eq","valuea":"63zggLRdt9j.#_checked","typea":"var","valueb":true,"typeb":"boolean"},{"kind":"compare","operator":"eq","valuea":"5dtio20wU05.#_checked","typea":"var","valueb":true,"typeb":"boolean"}]}},"thenActions":[{"kind":"eval_interaction","id":"_this.6g3T5skR7Xq"}],"elseActions":[{"kind":"gotoplay","window":"MessageWnd","wndtype":"normal","objRef":{"type":"string","value":"_player.MsgScene_5jHT91ztsz2.InvalidPromptSlide"}}]},{"kind":"exe_actiongroup","id":"_this.NavigationRestrictionNextSlide_6Zkvahkl2ag"}]},"ReviewInt_6p1tpRzxNPM":{"kind":"actiongroup","actions":[{"kind":"set_enabled","objRef":{"type":"string","value":"6Uds3r1HeGv"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"63zggLRdt9j"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"5dtio20wU05"},"enabled":{"type":"boolean","value":false}},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"6g3T5skR7Xq.$Status","typea":"property","valueb":"correct","typeb":"string"}},"thenActions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6p1tpRzxNPM_CorrectReview"}}],"elseActions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6p1tpRzxNPM_IncorrectReview"}}]},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#CurrentQuiz_6p1tpRzxNPM","typea":"var","valueb":"6HyXgqrh1xK","typeb":"string"}},"thenActions":[{"kind":"exe_actiongroup","id":"SetLayout_pxabnsnfns01001010101"},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.6HyXgqrh1xK.$Passed","typea":"property","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewIntCorrectIncorrect_6p1tpRzxNPM"}]},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.6HyXgqrh1xK.$Passed","typea":"property","valueb":false,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewIntCorrectIncorrect_6p1tpRzxNPM"}]}]}]},"ReviewIntCorrectIncorrect_6p1tpRzxNPM":{"kind":"actiongroup","actions":[{"kind":"set_enabled","objRef":{"type":"string","value":"6Uds3r1HeGv"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"63zggLRdt9j"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"5dtio20wU05"},"enabled":{"type":"boolean","value":false}}]},"AnsweredInt_6p1tpRzxNPM":{"kind":"actiongroup","actions":[{"kind":"exe_actiongroup","id":"DisableChoices_6p1tpRzxNPM"},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"pxabnsnfns01001010101"}],"elseActions":[{"kind":"set_window_control_layout","name":"pxabnsnfns01001010101"}]}]},"DisableChoices_6p1tpRzxNPM":{"kind":"actiongroup","actions":[{"kind":"set_enabled","objRef":{"type":"string","value":"6Uds3r1HeGv"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"63zggLRdt9j"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"5dtio20wU05"},"enabled":{"type":"boolean","value":false}}]},"6p1tpRzxNPM_CheckAnswered":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"or","statements":[{"kind":"compare","operator":"eq","valuea":"6g3T5skR7Xq.$Status","typea":"property","valueb":"correct","typeb":"string"},{"kind":"compare","operator":"eq","valuea":"_player.6HyXgqrh1xK.$QuizComplete","typea":"property","valueb":true,"typeb":"boolean"}]}},"thenActions":[{"kind":"exe_actiongroup","id":"AnsweredInt_6p1tpRzxNPM"}],"elseActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"6g3T5skR7Xq.$Status","typea":"property","valueb":"incorrect","typeb":"string"}},"thenActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"gte","valuea":"6g3T5skR7Xq.$AttemptCount","typea":"property","valueb":1,"typeb":"number"}},"thenActions":[{"kind":"exe_actiongroup","id":"AnsweredInt_6p1tpRzxNPM"}]}]}]}]},"SetLayout_pxabnsnfns01001010101":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"pxabnsnfns01001010101"}],"elseActions":[{"kind":"set_window_control_layout","name":"pxabnsnfns01001010101"}]}]},"NavigationRestrictionNextSlide_6Zkvahkl2ag":{"kind":"actiongroup","actions":[{"kind":"gotoplay","window":"_current","wndtype":"normal","objRef":{"type":"string","value":"_parent.6EH67VlV6yJ"}}]},"NavigationRestrictionPreviousSlide_6Zkvahkl2ag":{"kind":"actiongroup","actions":[{"kind":"history_prev"}]}},"events":[{"kind":"onbeforeslidein","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"npnxnanbsnfns01001010101"}],"elseActions":[{"kind":"set_window_control_layout","name":"npnxnanbsnfns01001010101"}]}]},{"kind":"onsubmitslide","actions":[{"kind":"exe_actiongroup","id":"ActGrpOnSubmitButtonClick"}]},{"kind":"ontransitionin","actions":[{"kind":"if_action","condition":{"statement":{"kind":"and","statements":[{"kind":"compare","operator":"eq","valuea":"_player.#TimelineCompleted_6Zkvahkl2ag","typea":"var","valueb":false,"typeb":"boolean"},{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_6p1tpRzxNPM","typea":"var","valueb":false,"typeb":"boolean"}]}},"thenActions":[{"kind":"enable_frame_control","name":"next","enable":false},{"kind":"enable_frame_control","name":"swiperight","enable":false}]},{"kind":"adjustvar","variable":"_player.LastSlideViewed_5jHT91ztsz2","operator":"set","value":{"type":"string","value":"_player."}},{"kind":"adjustvar","variable":"_player.LastSlideViewed_5jHT91ztsz2","operator":"add","value":{"type":"property","value":"$AbsoluteId"}},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_6p1tpRzxNPM","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewInt_6p1tpRzxNPM"}],"elseActions":[{"kind":"exe_actiongroup","id":"6p1tpRzxNPM_CheckAnswered"}]}]},{"kind":"onnextslide","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_6p1tpRzxNPM","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#CurrentQuiz_6p1tpRzxNPM","typea":"var","valueb":"6HyXgqrh1xK","typeb":"string"}},"thenActions":[{"kind":"nextviewedslide","quizRef":{"type":"string","value":"_player.6HyXgqrh1xK"},"completed_slide_ref":{"type":"string","value":"_player.5mbKk5DfB96.5nnSyv28G8M"}}],"elseActions":[]}],"elseActions":[{"kind":"exe_actiongroup","id":"NavigationRestrictionNextSlide_6Zkvahkl2ag"}]}]},{"kind":"onprevslide","actions":[{"kind":"exe_actiongroup","id":"NavigationRestrictionPreviousSlide_6Zkvahkl2ag"}]},{"kind":"ontimelinecomplete","actions":[{"kind":"adjustvar","variable":"_player.TimelineCompleted_6Zkvahkl2ag","operator":"set","value":{"type":"boolean","value":true}},{"kind":"enable_frame_control","name":"next","enable":true},{"kind":"enable_frame_control","name":"swiperight","enable":true}]}],"slideLayers":[{"enableSeek":true,"enableReplay":true,"timeline":{"duration":3000,"events":[{"kind":"ontimelinetick","time":0,"actions":[{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"5dPCmPfhdpX"}}]},{"kind":"ontimelinetick","time":750,"actions":[{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"5Vcd7WiVogs"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5dtio20wU05"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"63zggLRdt9j"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6Uds3r1HeGv"}}]},{"kind":"ontimelinetick","time":1000,"actions":[{"kind":"show","transition":"custom","animationId":"Entrance","reverse":false,"objRef":{"type":"string","value":"6NRcleAaWUN"}}]}]},"objects":[{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":11,"id":"01","url":"story_content/5cwtfcSsrE7_80_P_0_41_1440_1208_DX1250_DY1250.swf","type":"normal","altText":"metal_shelf2.png","width":1440,"height":1208,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":373,"yPos":0,"tabIndex":1,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":312.5,"rotateYPos":262.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":1,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":625,"bottom":525,"altText":"metal_shelf2.png","pngfb":false,"pr":{"l":"Lib","i":25}},"html5data":{"xPos":0,"yPos":0,"width":625,"height":525,"strokewidth":0}},"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"mask":{"type":"randombars","settings":[{"kind":"setting","name":"direction","value":"horizontal"}],"duration":750,"easing":"linear","easingdir":"easeinout"}}]}],"width":625,"height":525,"resume":true,"useHandCursor":true,"id":"5Vcd7WiVogs"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"5dPCmPfhdpX_1822340627","id":"01","linkId":"txt__default_5dPCmPfhdpX","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":348,"bottom":428,"pngfb":false,"pr":{"l":"Lib","i":27}}}],"shapemaskId":"","xPos":25,"yPos":0,"tabIndex":0,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":182,"rotateYPos":280.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":2,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":364,"bottom":561,"altText":"How would you categorize products/resources that deal with these topics?\\n\\nSkill Development\\nStrength & Conditioning\\nHealth & Nutrition\\nSpeed & Quickness \\nSport-Specific Strategy\\n\\nSelect a shelf to the right.\\n","pngfb":false,"pr":{"l":"Lib","i":26}},"html5data":{"xPos":-1,"yPos":-1,"width":365,"height":562,"strokewidth":0}},"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":750,"easing":"linear","easingdir":"easein"}},{"kind":"tween","time":0,"duration":750,"position":{"relativerotation":false,"relativestartpoint":false,"path":[{"kind":"segment","type":"line","anchora":{"x":"$RawXPos","y":"$RawYPos","dx":"0","dy":"-566"},"anchorb":{"x":"$RawXPos","y":"$RawYPos","dx":"0","dy":"0"}}],"duration":750,"easing":"cubic","easingdir":"easeout"}}]}],"width":364,"height":561,"resume":true,"useHandCursor":true,"id":"5dPCmPfhdpX"},{"kind":"vectorshape","rotation":0,"accType":"radio","cliptobounds":false,"defaultAction":"onrelease","shapemaskId":"","xPos":428,"yPos":321,"tabIndex":5,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":271,"rotateYPos":64,"scaleX":100,"scaleY":100,"alpha":100,"depth":3,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":542,"bottom":128,"altText":"Rectangle 4","pngfb":false,"pr":{"l":"Lib","i":28}},"html5data":{"xPos":-1,"yPos":-1,"width":543,"height":129,"strokewidth":0}},"states":[{"kind":"state","name":"_default_Selected","data":{"hotlinkId":"","accState":16,"vectorData":{"left":-2,"top":-2,"right":544,"bottom":130,"altText":"Rectangle 1","pngfb":false,"pr":{"l":"Lib","i":29}},"html5data":{"xPos":-2,"yPos":-2,"width":546,"height":132,"strokewidth":2}}},{"kind":"state","name":"_default_Hover","data":{"hotlinkId":"","accState":0,"vectorData":{"left":-2,"top":-2,"right":544,"bottom":130,"altText":"Rectangle 1","pngfb":false,"pr":{"l":"Lib","i":30}},"html5data":{"xPos":-2,"yPos":-2,"width":546,"height":132,"strokewidth":2}}},{"kind":"state","name":"_default_Hover_Selected","data":{"hotlinkId":"","accState":16,"vectorData":{"left":-2,"top":-2,"right":544,"bottom":130,"altText":"Rectangle 1","pngfb":false,"pr":{"l":"Lib","i":31}},"html5data":{"xPos":-2,"yPos":-2,"width":546,"height":132,"strokewidth":3}}}],"width":542,"height":128,"resume":true,"useHandCursor":true,"id":"5dtio20wU05","variables":[{"kind":"variable","name":"_hover","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_checked","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_state","type":"string","value":"_default","resume":true},{"kind":"variable","name":"_disabled","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_stateName","type":"string","value":"","resume":true},{"kind":"variable","name":"_tempStateName","type":"string","value":"","resume":false}],"actionGroups":{"ActGrpSetCheckedState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_checked","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}},{"kind":"exe_actiongroup","id":"ActGrpUnchecked"}]},"ActGrpUnchecked":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_parent.63zggLRdt9j.#_checked","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"adjustvar","variable":"_parent.63zggLRdt9j._checked","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_parent.63zggLRdt9j"}}]},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_parent.6Uds3r1HeGv.#_checked","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"adjustvar","variable":"_parent.6Uds3r1HeGv._checked","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_parent.6Uds3r1HeGv"}}]}]},"ActGrpSetHoverState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_hover","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpClearHoverState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_hover","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpClearStateVars":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_hover","operator":"set","value":{"type":"boolean","value":false}},{"kind":"adjustvar","variable":"_checked","operator":"set","value":{"type":"boolean","value":false}}]}},"events":[{"kind":"ontransitionin","actions":[{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onrollover","actions":[{"kind":"exe_actiongroup","id":"ActGrpSetHoverState","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onrollout","actions":[{"kind":"exe_actiongroup","id":"ActGrpClearHoverState","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onrelease","actions":[{"kind":"exe_actiongroup","id":"_this.ActGrpUnchecked"},{"kind":"adjustvar","variable":"_checked","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]}]},{"kind":"vectorshape","rotation":0,"accType":"radio","cliptobounds":false,"defaultAction":"onrelease","shapemaskId":"","xPos":428,"yPos":192,"tabIndex":4,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":271,"rotateYPos":67.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":4,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":542,"bottom":135,"altText":"Rectangle 4","pngfb":false,"pr":{"l":"Lib","i":32}},"html5data":{"xPos":-1,"yPos":-1,"width":543,"height":136,"strokewidth":0}},"states":[{"kind":"state","name":"_default_Selected","data":{"hotlinkId":"","accState":16,"vectorData":{"left":-2,"top":-2,"right":544,"bottom":136,"altText":"Rectangle 2","pngfb":false,"pr":{"l":"Lib","i":33}},"html5data":{"xPos":-2,"yPos":-2,"width":546,"height":138,"strokewidth":2}}},{"kind":"state","name":"_default_Hover","data":{"hotlinkId":"","accState":0,"vectorData":{"left":-2,"top":-2,"right":544,"bottom":136,"altText":"Rectangle 2","pngfb":false,"pr":{"l":"Lib","i":34}},"html5data":{"xPos":-2,"yPos":-2,"width":546,"height":138,"strokewidth":2}}},{"kind":"state","name":"_default_Hover_Selected","data":{"hotlinkId":"","accState":16,"vectorData":{"left":-2,"top":-2,"right":544,"bottom":137,"altText":"Rectangle 2","pngfb":false,"pr":{"l":"Lib","i":35}},"html5data":{"xPos":-2,"yPos":-2,"width":546,"height":139,"strokewidth":3}}}],"width":542,"height":135,"resume":true,"useHandCursor":true,"id":"63zggLRdt9j","variables":[{"kind":"variable","name":"_hover","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_checked","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_state","type":"string","value":"_default","resume":true},{"kind":"variable","name":"_disabled","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_stateName","type":"string","value":"","resume":true},{"kind":"variable","name":"_tempStateName","type":"string","value":"","resume":false}],"actionGroups":{"ActGrpSetCheckedState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_checked","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}},{"kind":"exe_actiongroup","id":"ActGrpUnchecked"}]},"ActGrpUnchecked":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_parent.5dtio20wU05.#_checked","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"adjustvar","variable":"_parent.5dtio20wU05._checked","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_parent.5dtio20wU05"}}]},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_parent.6Uds3r1HeGv.#_checked","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"adjustvar","variable":"_parent.6Uds3r1HeGv._checked","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_parent.6Uds3r1HeGv"}}]}]},"ActGrpSetHoverState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_hover","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpClearHoverState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_hover","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpClearStateVars":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_hover","operator":"set","value":{"type":"boolean","value":false}},{"kind":"adjustvar","variable":"_checked","operator":"set","value":{"type":"boolean","value":false}}]}},"events":[{"kind":"ontransitionin","actions":[{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onrollover","actions":[{"kind":"exe_actiongroup","id":"ActGrpSetHoverState","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onrollout","actions":[{"kind":"exe_actiongroup","id":"ActGrpClearHoverState","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onrelease","actions":[{"kind":"exe_actiongroup","id":"_this.ActGrpUnchecked"},{"kind":"adjustvar","variable":"_checked","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]}]},{"kind":"vectorshape","rotation":0,"accType":"radio","cliptobounds":false,"defaultAction":"onrelease","shapemaskId":"","xPos":426,"yPos":57,"tabIndex":3,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":271,"rotateYPos":67.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":5,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":542,"bottom":135,"altText":"Rectangle 4","pngfb":false,"pr":{"l":"Lib","i":32}},"html5data":{"xPos":-1,"yPos":-1,"width":543,"height":136,"strokewidth":0}},"states":[{"kind":"state","name":"_default_Selected","data":{"hotlinkId":"","accState":16,"vectorData":{"left":-2,"top":-2,"right":544,"bottom":136,"altText":"Rectangle 3","pngfb":false,"pr":{"l":"Lib","i":33}},"html5data":{"xPos":-2,"yPos":-2,"width":546,"height":138,"strokewidth":2}}},{"kind":"state","name":"_default_Hover","data":{"hotlinkId":"","accState":0,"vectorData":{"left":-2,"top":-2,"right":544,"bottom":136,"altText":"Rectangle 3","pngfb":false,"pr":{"l":"Lib","i":34}},"html5data":{"xPos":-2,"yPos":-2,"width":546,"height":138,"strokewidth":2}}},{"kind":"state","name":"_default_Hover_Selected","data":{"hotlinkId":"","accState":16,"vectorData":{"left":-2,"top":-2,"right":544,"bottom":137,"altText":"Rectangle 3","pngfb":false,"pr":{"l":"Lib","i":35}},"html5data":{"xPos":-2,"yPos":-2,"width":546,"height":139,"strokewidth":3}}}],"width":542,"height":135,"resume":true,"useHandCursor":true,"id":"6Uds3r1HeGv","variables":[{"kind":"variable","name":"_hover","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_checked","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_state","type":"string","value":"_default","resume":true},{"kind":"variable","name":"_disabled","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_stateName","type":"string","value":"","resume":true},{"kind":"variable","name":"_tempStateName","type":"string","value":"","resume":false}],"actionGroups":{"ActGrpSetCheckedState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_checked","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}},{"kind":"exe_actiongroup","id":"ActGrpUnchecked"}]},"ActGrpUnchecked":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_parent.5dtio20wU05.#_checked","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"adjustvar","variable":"_parent.5dtio20wU05._checked","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_parent.5dtio20wU05"}}]},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_parent.63zggLRdt9j.#_checked","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"adjustvar","variable":"_parent.63zggLRdt9j._checked","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_parent.63zggLRdt9j"}}]}]},"ActGrpSetHoverState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_hover","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpClearHoverState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_hover","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpClearStateVars":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_hover","operator":"set","value":{"type":"boolean","value":false}},{"kind":"adjustvar","variable":"_checked","operator":"set","value":{"type":"boolean","value":false}}]}},"events":[{"kind":"ontransitionin","actions":[{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onrollover","actions":[{"kind":"exe_actiongroup","id":"ActGrpSetHoverState","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onrollout","actions":[{"kind":"exe_actiongroup","id":"ActGrpClearHoverState","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onrelease","actions":[{"kind":"exe_actiongroup","id":"_this.ActGrpUnchecked"},{"kind":"adjustvar","variable":"_checked","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]}]},{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":12,"id":"01","url":"story_content/6Y7o17DUtyf_80_DX164_DY164.swf","type":"normal","altText":"finger.png","width":164,"height":164,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":166,"yPos":436,"tabIndex":6,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":41,"rotateYPos":41,"scaleX":100,"scaleY":100,"alpha":100,"depth":6,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":82,"bottom":82,"altText":"finger.png","pngfb":false,"pr":{"l":"Lib","i":36}},"html5data":{"xPos":0,"yPos":0,"width":82,"height":82,"strokewidth":0}},"animations":[{"kind":"animation","id":"Entrance","duration":750,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":750,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":750,"easing":"linear","easingdir":"easein"}},{"kind":"tween","time":0,"duration":750,"position":{"relativerotation":false,"relativestartpoint":false,"path":[{"kind":"segment","type":"line","anchora":{"x":"$RawXPos","y":"$RawYPos","dx":"0","dy":"131"},"anchorb":{"x":"$RawXPos","y":"$RawYPos","dx":"0","dy":"0"}}],"duration":750,"easing":"cubic","easingdir":"easeout"}}]}],"width":82,"height":82,"resume":true,"useHandCursor":true,"id":"6NRcleAaWUN"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"6p1tpRzxNPM_CorrectReview","id":"01","linkId":"6p1tpRzxNPM_CorrectReview","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":540,"bottom":37,"pngfb":false,"pr":{"l":"Lib","i":38}}}],"shapemaskId":"","xPos":0,"yPos":522,"tabIndex":7,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":500,"rotateYPos":20,"scaleX":100,"scaleY":100,"alpha":100,"depth":7,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":1000,"bottom":40,"altText":"Correct","pngfb":false,"pr":{"l":"Lib","i":37}},"html5data":{"xPos":1,"yPos":1,"width":997,"height":37,"strokewidth":2}},"width":1000,"height":40,"resume":false,"useHandCursor":true,"id":"6p1tpRzxNPM_CorrectReview","events":[{"kind":"onrelease","actions":[{"kind":"hide","transition":"appear","objRef":{"type":"string","value":"_this"}}]}]},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"6p1tpRzxNPM_IncorrectReview","id":"01","linkId":"6p1tpRzxNPM_IncorrectReview","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":549,"bottom":37,"pngfb":false,"pr":{"l":"Lib","i":40}}}],"shapemaskId":"","xPos":0,"yPos":522,"tabIndex":8,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":500,"rotateYPos":20,"scaleX":100,"scaleY":100,"alpha":100,"depth":8,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":1000,"bottom":40,"altText":"Incorrect","pngfb":false,"pr":{"l":"Lib","i":39}},"html5data":{"xPos":1,"yPos":1,"width":997,"height":37,"strokewidth":2}},"width":1000,"height":40,"resume":false,"useHandCursor":true,"id":"6p1tpRzxNPM_IncorrectReview","events":[{"kind":"onrelease","actions":[{"kind":"hide","transition":"appear","objRef":{"type":"string","value":"_this"}}]}]}],"startTime":-1,"elapsedTimeMode":"normal","animations":[{"kind":"animation","id":"5xFOgIZLpu7","duration":500,"hidetextatstart":true,"animateshapewithtext":false,"tweens":[{"kind":"tween","time":0,"duration":500,"alpha":{"path":[{"kind":"segment","start":"0","dstart":"0","end":"100","dend":"0"}],"duration":500,"easing":"linear","easingdir":"easein"}}]}],"useHandCursor":false,"resume":true,"kind":"slidelayer","isBaseLayer":true}]}');