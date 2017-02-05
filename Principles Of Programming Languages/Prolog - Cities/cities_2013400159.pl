%CMPE260 Prolog 
%Batuhan Demir
%2013400159

road(london, paris, 459 ).
road(paris, berlin, 1054 ).
road(paris, barcelona, 1036 ).
road(barcelona, milano, 981 ).
road(milano, budapest, 960 ).
road(berlin, budapest, 874 ).
road(budapest, istanbul, 1319 ).

language(london, english ).
language(paris, french ).
language(paris, arabic ).
language(berlin, german ).
language(berlin, turkish ).
language(barcelona, spanish ).
language(barcelona, catalan ).
language(barcelona, italian ).
language(milano, italian ).
language(budapest, hungarian ).
language(istanbul, turkish ).
language(istanbul, arabic ).

communicate_with(Citya,Cityb,Lang):-language(Citya,Lang),language(Cityb,Lang),\+Citya=Cityb.

communicate(Citya,Cityb):-language(Citya,X),language(Cityb,X),\+Citya=Cityb.

cities_of_language(X,L):-findall(A,language(A,X),L).

languages_of_city(City,L):-findall(A,language(City,A),L).

is_connected(A,B):-road(A,B,_);road(A,C,_),is_connected(C,B),A\=B,A\=C.

distance(A,B,D):-road(A,B,D);road(A,C,D1),distance(C,B,D2),D is D1+D2,A\=B,B\=C.

connected_cities(A,L):-findall(X,is_connected(A,X),LL),sort(LL,L).

minimum_distance(A,B,D):-findall(DD,distance(A,B,DD),L),min_list(L,D).





