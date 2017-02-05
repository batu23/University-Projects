

[y1,F]=audioread('mike.wav');
[y2,F]=audioread('street.wav');

%%%%Create mike+street sound
y3 = [y1+y2];
audiowrite('noisy.wav',y3,F);

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%%% FILTERING %%%%%%%%%%%%%%%%%%%%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
Ws = 250/(F/2);
Wp = 3500/(F/2);
[N,Wn] = buttord(Wp,Ws,0.5,50);
[b,a] = butter(N,Wn);
fout = filter(b,a,y3);

% Wn = 250/(F/2);                   % Normalized cutoff frequency        
% [z,p] = butter(11,Wn,'high');  % Butterworth filter
%   
% fout = filter(z, p, y3);

% sound(y3,F);
% pause(9);
% sound(fout,F);

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%%% 1- FREQURNCY Domain %%%%%%%%%%%%%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
figure

N = size(y1,1);
df = F / N;
w = (-(N/2):(N/2)-1)*df;
y_1 = fft(y1(:,1), N) / N; %//For normalizing, but not needed for our analysis
yy = fftshift(y_1);
subplot(3,1,1)
plot(w,abs(yy));
xlim([-0.8e4 0.8e4]);
ylim([0 1.5e-3]);
xlabel('Freq in Hz');
ylabel('Magnitude');
title('Mike Freq Domain')
hold on;

N2 = size(y2,1);
df2 = F / N2;
w2 = (-(N2/2):(N2/2)-1)*df2;
y_2 = fft(y2(:,1), N2) / N2; %//For normalizing, but not needed for our analysis
yy2 = fftshift(y_2);
subplot(3,1,2)
plot(w2,abs(yy2));
xlim([-0.8e4 0.8e4]);
ylim([0 1.5e-3]);
title('Street Freq Domain')
hold on;

N3 = size(y3,1);
df3 = F / N3;
w3 = (-(N3/2):(N3/2)-1)*df3;
y_3 = fft(y3(:,1), N3) / N3; %//For normalizing, but not needed for our analysis
yy3 = fftshift(y_3);
subplot(3,1,3)
plot(w3,abs(yy3));
xlim([-0.8e4 0.8e4]);
ylim([0 1.5e-3]);
title('Mike+Street Freq Domain')
hold on;



%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%%% TIME Domain %%%%%%%%%%%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%
figure

t=0:1/F:(length(y1)-1)/F;
subplot(3,1,1)
plot(t,y1)
title('Mike Time Domain');
xlabel('Time in Sec');
ylabel('Amplitude');
hold on;

t1=0:1/F:(length(y2)-1)/F;
subplot(3,1,2)
plot(t1,y2)
title('Street Time Domain');
hold on;

t2=0:1/F:(length(y3)-1)/F;
subplot(3,1,3)
plot(t2,y3)
ylim([-0.2 0.4]);
title('Mike+Street Time Domain');
hold on;

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%%%%%%% 3- FREQUENCY domain%%%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
figure

subplot(2,1,1)
plot(w,abs(yy));
xlim([-0.8e4 0.8e4]);
ylim([0 1.5e-3]);
xlabel('Freq in Hz');
ylabel('Magnitude');
title('Mike Freq Domain');
hold on;

subplot(2,1,2)
NN3 = size(fout,1);
dff3 = F / NN3;
ww3 = (-(NN3/2):(NN3/2)-1)*dff3;
fout_1 = fft(fout(:,1), NN3) / NN3; %//For normalizing, but not needed for our analysis
ffout= fftshift(fout_1);
plot(ww3,abs(ffout));
xlim([-0.8e4 0.8e4]);
ylim([0 1.5e-3]);
title('Filtered Mike+Street Freq Domain')
hold on;

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%%%%%% 4- TIME domain%%%%%%%%%%%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
figure

subplot(2,1,1)
plot(t,y1)
title('Mike Time Domain');
xlabel('Time in Sec');
ylabel('Amplitude');
hold on;

subplot(2,1,2)
t_fout=0:1/F:(length(fout)-1)/F;
plot(t_fout,fout)
title('Filtered Mike+Street Time Domain');
hold on;

%%%%%%%%%%%%%%%%%%%%%%%%%
%%%%%%%% SNR Value%%%%%%%%
%%%%%%%%%%%%%%%%%%%%%%%%%

s = mean(y1.^2)/mean((fout-y1).^2);
snr = 10.^log(s);







