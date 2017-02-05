hfile = dir('*.wav');

for id = 1 : numel(hfile);
    d = fullfile(hfile(id).name);
    [stereo1, Fs] = audioread(d);
    mono1 = mean(stereo1,2);

    [max_value,idx] = max(mono1);
    threshold = 0.25; %// amplitude threshold
    radius = 4000 ; %// data around clap
    number_of_claps = 0;
    while max_value > threshold
        min_bound = max(1,idx-radius);
        max_bound = min(idx+radius,length(mono1));
        mono1(min_bound:max_bound) = 0; %// after a clap found, delete it
        [max_value,idx] = max(mono1);
        number_of_claps = number_of_claps + 1;
    end

    if number_of_claps<=1
        disp('one clap')
    else 
        disp('two claps')
    end
end

 