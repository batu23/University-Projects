% % % % % % % Watermark on Time Domain % % % % %% % 

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
message1=reshape(message,1,[]);

% % % % % % % % % % % % % % % % % % % % % % % % % % % 
% % % % % % % % Watermark Embedding % % %  %% % % % % % 
% % % % % % % % % % % % % % % % % % % % % % % % %  

% This new array’s elements will be embedded to audio

% Embed every one byte in four bytes of the audio file.
for ii = 1:4:Mc
        watermark1(ii)=message1(mod(ii,4)+1);
end
watermarked_audio=cover_audio;

% If the element is ‘0’ use bitwise ‘AND’. Otherwise use bitwise ‘OR’ 
% with the audio byte arrays specified bit.
for ii = 1:4:Mc
        watermarked_audio(ii)=bitset(cast(watermarked_audio(ii),'uint8'),1,watermark1(ii));
end
audiowrite('lsb_watermarked.wav',watermarked_audio,Fs); 

% % % % % % % % % % % % % % % % % % % % % % % % % % % 
% % % % % % % % Watermark Extraction % % %  %% % % % % % 
% % % % % % % % % % % % % % % % % % % % % % % % % % %  

file_name='lsb_watermarked.wav'; 
[watermarked_audio,Fs]=audioread(file_name);

% get size of watermarked audio
Mw=size(watermarked_audio,1);	

% Retrieve the embedded bit by applying bit operation
for ii = 1:4:Mw
        watermark(ii)=bitget(cast(watermarked_audio(ii),'uint8'),1);
end

% Convert pixel value array as an M x N two - dimensional matrix
% watermarkex= reshape(watermark,64,64);
% Represent this resulting 2D matrix as a gray scale image.
% Since i dont have Image Processing Toolbox i cannot use Mat2gray function

%%%%%%%%%%%%%%%%%%%%%%%%%%
%%%%%%%% SNR Value%%%%%%%%
%%%%%%%%%%%%%%%%%%%%%%%%%

s = mean(cover_audio.^2)/mean((cover_audio-watermarked_audio).^2);
% s = mean(watermarked_audio.^2)/mean((watermarked_audio-cover_audio).^2);
snr = 10.^log(s);


