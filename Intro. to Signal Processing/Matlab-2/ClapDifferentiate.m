[stereo1, F] = audioread('*.wav'); 

% % % THERE MUST BE ONLY 1 WAV FILE IN THE DIRECTORY!!!

mono1 = mean(stereo1,2);

% sound(stereo1,F);

figure
N = size(mono1,1);
df = F / N;
w = (-(N/2):(N/2)-1)*df;
y = fft(mono1(:,1), N) / N; %//For normalizing
yy = fftshift(y);
plot(w,abs(yy));
xlabel('Freq in Hz');
ylabel('Magnitude');
title('Freq Domain | Before')

% pause(2);

Ws = 5/(F/2);
Wp = 2200/(F/2);
[N,Wn] = buttord(Wp,Ws,0.5,10);
[b,a] = butter(N,Wn);
fout = filter(b,a,mono1);

% sound(fout,F);

figure
N = size(fout,1);
df = F / N;
w = (-(N/2):(N/2)-1)*df;
y = fft(fout(:,1), N) / N; %//For normalizing
yy = fftshift(y);
plot(w,abs(yy));
xlabel('Freq in Hz');
ylabel('Magnitude');
title('Freq Domain | After')

[max_value,idx] = max(fout);

if max_value<0.006
    disp('Snap sound detected')
else 
    disp('Clap sound detected')
end