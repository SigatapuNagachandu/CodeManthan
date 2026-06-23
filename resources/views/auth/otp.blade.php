@extends('layouts.app')

@section('title', 'OTP Verification - CodeManthan Security Hub')

@section('content')
<div class="min-h-[calc(100vh-8rem)] flex items-center justify-center bg-monochrome-mesh py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    
    <div class="max-w-md w-full space-y-8 relative z-10">
        
        <!-- Platform Branding Header -->
        <div class="text-center">
            <div class="w-12 h-12 bg-black dark:bg-white text-white dark:text-black border-2 border-black dark:border-white flex items-center justify-center font-black text-lg mx-auto mb-4">
                K
            </div>
            <h2 class="text-3xl font-black uppercase tracking-tight text-slate-900 dark:text-white">
                Two-Factor Gates
            </h2>
            <p class="mt-2 text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-zinc-550">
                Provide the 6-digit security code generated for your session
            </p>
        </div>

        <!-- Glassmorphism OTP Card -->
        <div class="bg-white dark:bg-black border-2 border-black dark:border-white shadow-3d p-8 rounded-none transition-colors duration-200" x-data="{
            otpDigits: ['', '', '', '', '', ''],
            handleInput(index, val) {
                if (val.length > 0) {
                    this.otpDigits[index] = val.slice(-1);
                    if (index < 5) {
                        this.$refs['input_' + (index + 1)].focus();
                    }
                }
            },
            handleBackspace(index, event) {
                if (event.key === 'Backspace') {
                    if (this.otpDigits[index] === '' && index > 0) {
                        this.otpDigits[index - 1] = '';
                        this.$refs['input_' + (index - 1)].focus();
                    } else {
                        this.otpDigits[index] = '';
                    }
                }
            }
        }">
            
            <!-- Sandbox Helper Notification Panel -->
            @if(session('sandbox_otp'))
                <div class="p-4 mb-6 border-2 border-black dark:border-white bg-slate-50 dark:bg-zinc-900 text-black dark:text-white flex items-start gap-3 relative shadow-3d-stark">
                    <div class="w-7 h-7 bg-black dark:bg-white text-white dark:text-black border border-black flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-code text-xs"></i>
                    </div>
                    <div class="flex-grow">
                        <h4 class="text-[9px] font-black uppercase tracking-widest">Sandbox PIN Indicator</h4>
                        <p class="text-[11px] text-slate-500 dark:text-zinc-400 mt-0.5 leading-relaxed font-semibold">
                            Copy this local security key: 
                            <strong class="font-mono text-sm text-black dark:text-white select-all tracking-widest block mt-1.5 bg-white dark:bg-black px-3 py-1 border border-black dark:border-white w-fit">{{ session('sandbox_otp') }}</strong>
                        </p>
                    </div>
                </div>
            @endif

            <form class="space-y-6" action="{{ route('login.otp') }}" method="POST">
                @csrf
                
                <!-- 6 Digits Inputs Cells -->
                <div class="flex justify-between gap-2">
                    @for($i = 0; $i < 6; $i++)
                        <input 
                            x-ref="input_{{ $i }}"
                            type="text" 
                            name="otp[]"
                            maxlength="1"
                            x-model="otpDigits[{{ $i }}]"
                            @input="handleInput({{ $i }}, $el.value)"
                            @keydown="handleBackspace({{ $i }}, $event)"
                            class="w-11 h-14 sm:w-12 sm:h-16 text-center text-2xl font-black bg-slate-50 dark:bg-zinc-900 border-2 border-black dark:border-zinc-800 rounded-none text-slate-900 dark:text-white focus:outline-none focus:bg-white transition-all duration-150"
                            required>
                    @endfor
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-4 bg-black dark:bg-white text-white dark:text-black border-2 border-black dark:border-white font-extrabold uppercase tracking-widest text-xs hover:-translate-x-0.5 hover:-translate-y-0.5 transition-all shadow-3d flex items-center justify-center gap-2">
                    Confirm Key
                    <i class="fa-solid fa-circle-check"></i>
                </button>
            </form>

            <div class="text-center mt-6">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Didn't receive the credentials key?</p>
                <button onclick="window.location.reload();" class="mt-1.5 text-xs font-black uppercase tracking-wider text-black dark:text-white hover:underline">
                    Generate New Key
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
