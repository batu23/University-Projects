% % % % % % % Watermark on Wavelet Domain % % % % %% % 

% % % % % % % % % % % % % % % % % % % % % % % % % 
% % % % % % % % PREPROCESSING % % %  %% % % % % % 
% % % % % % % % % % % % % % % % % % % % % % % % %  
file_name='son.wav';  
[cover_audio,Fs]=audioread(file_name);
file_name='wm.bmp';  
message=imread(file_name);

% Represent the grey-scale image watermark as a two dimensional MxN matrix
message=double(message);   
message=round(message./256);
message=uint8(message);

% Read dimensions of the cover audio
Mc=size(cover_audio,1);		

% Read dimensions of the message picture
Mm=size(message,1);	        
Nm=size(message,2);
message=reshape(message,1,[]);
% Convert an audio signal into byte array.

% Level 1 Haar Decomposition
[A1, H1, L1, D1]=dwt2(cover_audio,'haar');

% level 2 Haar Decomposition
[A2, H2, L2, D2]=dwt2(A1,'haar');

% new=[L2 H2 H1];
% in2= idwt2(A1,H2,V2,D2,'haar');
% final= idwt2(in2,H1,V1,D1,'haar');
