% input and output file names for watermarking 

audio_input='son.wav';
watermark_input='wm.bmp';
output_marked='freqwatermarked.wav';
wm_output='wm_ex.bmp';

blocksize=8820;  % For a track with 44100 samples per second  
                 % this block size corresponds to a duration of 0.2 s
                 % therefore we have a fft frequency resolution of 5 Hz.  
first_block=1;  % to leave about 6 s empty
wm_peak=20;      % corresponds to a low frequency peak for the embedding;
         
amply=7;       % amplification factor for the watermarked spectral value
            
% Read audio-file, determine available watermark size 
[data,Fs]=audioread(audio_input);
data_orig=data; %hold value to calculate snr value
M=size(data,1);
N=floor(M/blocksize);  % both channels are used for watermark embedding

% Watermark preparation 

wm1=imread(watermark_input);  % read watermark image
z1=size(wm1,1);
z2=size(wm1,2);
scale=1;
if(N<(z1*z2)) 
    scale=N/(z1*z2); 
end
wm_temp=mat2gray(wm1);
if(scale~=1) 
    wm_temp=imresize(wm_temp,scale); 
% possibly scale watermark image to fit the audio file length
end

s1=floor(size(wm_temp,1)/2)*2;       % an even number
s2=floor(size(wm_temp,2)/2)*2;
wm=imresize(wm_temp,[s1 s2]);   % new image with even side lengths
wm_length=s1*s2;                % an even wm_length
wm_vec=round(reshape(wm,wm_length,1)./256);
if(wm_length>(N-first_block+1))
    error('Error: Watermark to long');
end
wm_pad(1:length(wm_vec))=wm_vec; % watermark bytes in a vector

% Watermark embedding
l=-1;
for k=first_block:wm_length/2+first_block-1   % k runs over the blocks
    l=l+2;            % l runs through the watermark bytes in steps by 2
    x=data((k-1)*blocksize+1:k*blocksize,1);
    y=fft(x);
    mark=0;       % search peaks with different absolute values
                  % beginning at number wm_peak
    n=wm_peak;    % start fft peak number
      while(abs(y(n))==abs(y(n+1)) && mark==0)
         n=n+1;
         if(n==floor(blocksize/2)) 
            mark=1;
         end
      end
    if(n~=floor(blocksize/2))   % otherwise do nothing, i.e. 
                                % then the watermark byte will be white
                                % for this block in the detection
                                % algorithm
      if(wm_pad(l)==0)      % Encode |y(n)|>|y(n+1| 
                              
            if(abs(y(n))<abs(y(n+1)))% change the values, if necessary
                temp1=y(n+1);
                y(n+1)=y(n);
                y(n)=temp1;
            end
            y(n)=y(n)*amply;       % an amplifying for better detection
            y(blocksize-n+2)=conj(y(n));   
            y(blocksize-n+1)=conj(y(n+1)); 
                                          
      end
      elseif(wm_pad(l)==1)         % white is embedded iff  
          if(abs(y(n))>abs(y(n+1)))    % [ |y(n)|<|y(n+1)| or all
                temp1=y(n+1);          % fft peaks have equal  
                y(n+1)=y(n);           % absolute values ]  
                y(n)=temp1;             
          end                          
            y(n+1)=y(n+1)*amply;             % 
            y(blocksize-n+2)=conj(y(n));     % analogously to above 
            y(blocksize-n+1)=conj(y(n+1));   %  

     end
    % inverse transform of the watermarked fft block  
    data((k-1)*blocksize+1:k*blocksize,1)=ifft(y); 
end


% Write watermarked audio-file
audiowrite(output_marked,data,Fs);

%%%%%%%%%%%%%%%%%%%%%%%%%%
%%%%%%%% SNR Value%%%%%%%%
%%%%%%%%%%%%%%%%%%%%%%%%%

s = mean(data_orig.^2)/mean((data_orig-data).^2);
snr = 10.^log(s);